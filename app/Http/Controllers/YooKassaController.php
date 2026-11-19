<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\YooKassaPaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class YooKassaController extends Controller
{
    public function return(Order $order, YooKassaPaymentService $yooKassaService): RedirectResponse
    {
        // Берем последнюю попытку оплаты
        $latestPayment = $order->latestPayment;

        if ($latestPayment && $latestPayment->external_payment_id) {
            try {
                // Идем в API и проверяем реальный статус
                $actualPayment = $yooKassaService->fetchPayment($latestPayment->external_payment_id);

                if ($actualPayment) {
                    $yooKassaService->synchronizePayment($actualPayment);
                }
            } catch (\Throwable $e) {
                Log::warning('YooKassa return: не удалось проверить платёж', [
                    'order_id'            => $order->id,
                    'external_payment_id' => $latestPayment->external_payment_id,
                    'error'               => $e->getMessage(),
                ]);
            }
        }

        $order->refresh();

        if ($order->status === Order::STATUS_PAID) {
            return redirect()->route('orders.index')->with('success', 'Заказ успешно оплачен!');
        }

        return redirect()->route('orders.index')->with('info', 'Платеж обрабатывается или был отменен.');
    }

    // 2. Метод webhook()
    public function webhook(Request $request, YooKassaPaymentService $yooKassaService): JsonResponse
    {
        try {
            $yooKassaService->handleWebhook($request->all());
        } catch (\Throwable $e) {
            Log::error('YooKassa webhook: ошибка обработки', [
                'error' => $e->getMessage(),
                'payload' => $request->all(),
            ]);
        }

        return response()->json(['status' => 'success']);
    }

    public function create(Order $order, YooKassaPaymentService $yooKassaService): RedirectResponse
    {
        $payment = $yooKassaService->createPaymentForOrder($order);

        if ($payment->confirmation_url) {
            return redirect($payment->confirmation_url);
        }

        return back()->with('error', 'Не удалось создать платеж');
    }
}
