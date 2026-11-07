<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\PaymentReceipt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use YooKassa\Client;
use YooKassa\Model\PaymentInterface;
use Exception;
use YooKassa\Request\Payments\PaymentResponse;

class YooKassaPaymentService
{
    private Client $client;
    private string $currency;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setAuth(
            config('services.yookassa.shop_id'),
            config('services.yookassa.secret_key')
        );
        $this->currency = config('services.yookassa.currency', 'RUB');
    }

    public function createPaymentForOrder(Order $order): OrderPayment
    {
        $idempotenceKey = (string) Str::uuid();

        $payload = [
            'amount' => [
                'value' => number_format((float) $order->total, 2, '.', ''),
                'currency' => $this->currency,
            ],
            'capture' => true,
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => route('payments.yookassa.return', $order),
            ],
            'description' => 'Оплата заказа #' . $order->id,
            'metadata' => [
                'order_id' => $order->id,
            ],
        ];

        if (config('services.yookassa.receipts.enabled')) {
            $payload['receipt'] = $this->createReceipt($order);
        }

        // ИСПОЛЬЗУЕМ SDK:
        try {
            $response = $this->client->createPayment($payload, $idempotenceKey);
        } catch (Exception $e) {
            Log::error('Ошибка SDK YooKassa: ' . $e->getMessage());
            throw $e;
        }

        // Сохраняем платеж (как и раньше)
        $orderPayment = OrderPayment::create([
            'order_id' => $order->id,
            'provider' => 'yookassa',
            'status' => $response->getStatus(),
            'amount' => $order->total,
            'currency' => $this->currency,
            'external_payment_id' => $response->getId(),
            'idempotence_key' => $idempotenceKey,
            'confirmation_url' => $response->getConfirmation()?->getConfirmationUrl(),
            'request_payload' => $payload,
            'response_payload' => $response->jsonSerialize(),
        ]);

        // Сохраняем чек (как мы обсуждали в прошлом шаге)
        if (isset($payload['receipt'])) {
            PaymentReceipt::create([
                'order_payment_id' => $orderPayment->id,
                'type' => 'payment',
                'status' => 'pending', // В SDK статус регистрации чека не всегда сразу возвращается в ответе на создание
                'send_to_customer' => true,
                'request_payload' => $payload['receipt'],
                'response_payload' => $response->jsonSerialize()['receipt'] ?? null,
            ]);
        }

        return $orderPayment;
    }

    public function handleWebhook(array $payload): void
    {
        $paymentId = $payload['object']['id'] ?? null;
        if (!$paymentId) {
            return;
        }

        $actualPayment = $this->fetchPayment($paymentId);
        if ($actualPayment) {
            $this->synchronizePayment($actualPayment);
        }
    }

    public function fetchPayment(string $paymentId): PaymentResponse
    {
        try {
            return $this->client->getPaymentInfo($paymentId);

        } catch (\Throwable $e) {

            Log::error("Не удалось получить платеж из YooKassa: {$paymentId}", [
                'error' => $e->getMessage(),
            ]);

            throw new \RuntimeException(
                "Не удалось получить платеж из YooKassa: {$paymentId}",
                0,
                $e
            );
        }
    }

    public function synchronizePayment(PaymentResponse $paymentData)
    {
        $localPayment = OrderPayment::where('external_payment_id', $paymentData->getId())->first();
        if (!$localPayment) {
            return;
        }

        $localPayment->update([
            'status' => $paymentData->getStatus(),
            'response_payload' => $paymentData->jsonSerialize(),
            'paid_at' => $paymentData->getStatus() === 'succeeded' ? now() : null,
            'canceled_at' => $paymentData->getStatus() === 'canceled' ? now() : null,
        ]);

        // Проверка статуса чека (если чек отправлялся)
        if ($paymentData->getReceiptRegistration()) {
            $receiptStatus = $paymentData->getReceiptRegistration(); // 'succeeded', 'pending', 'canceled'

            // Обновляем локальный чек
            $localReceipt = $localPayment->receipts()->first();
            if ($localReceipt) {
                $localReceipt->update(['status' => $receiptStatus]);

                // Если чек отвалился (canceled) — шлем задачу в RabbitMQ!
                if ($receiptStatus === 'canceled') {
                    \App\Jobs\NotifyManagerFailedReceiptJob::dispatch($localReceipt);
                }
            }
        }

        if ($paymentData->getStatus() === 'succeeded') {
            app(OrderService::class)->markAsPaid($localPayment->order);
        }
    }

    /**
     * Формирование массива чека
     */
    public function createReceipt(Order $order): array
    {
        $receiptsConfig = config('services.yookassa.receipts');

        $items = $order->items->map(function ($item) use ($receiptsConfig) {
            return [
                'description' => $item->product->name ?? 'Товар',
                'quantity' => (string) $item->quantity,
                'amount' => [
                    'value' => number_format((float) $item->price, 2, '.', ''),
                    'currency' => $this->currency,
                ],
                'vat_code' => (int) $receiptsConfig['vat_code'],
                'payment_mode' => $receiptsConfig['payment_mode'],
                'payment_subject' => $receiptsConfig['payment_subject'],
            ];
        })->toArray();

        return [
            'customer' => [
                // было: 'email' => $order->user->email,
                'email' => $order->user?->email ?? 'no-email@example.com',
            ],
            'items' => $items,
            'tax_system_code' => (int) $receiptsConfig['tax_system_code'],
        ];
    }
}
