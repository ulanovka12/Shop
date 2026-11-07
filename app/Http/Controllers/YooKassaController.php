<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\YooKassaPaymentService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class YooKassaController extends Controller
{
    // 1. Метод return()
    public function return(Order $order, YooKassaPaymentService $yooKassaService): RedirectResponse
    {
        // Берем последнюю попытку оплаты
        $latestPayment = $order->latestPayment;

        if ($latestPayment && $latestPayment->external_payment_id) {
            // Идем в API и проверяем реальный статус
            $actualPayment = $yooKassaService->fetchPayment($latestPayment->external_payment_id);

            if ($actualPayment) {
                $yooKassaService->synchronizePayment($actualPayment);
            }
        }

        // Обновляем модель заказа из базы, чтобы узнать актуальный статус
        $order->refresh();

        if ($order->status === Order::STATUS_PAID) {
            return redirect()->route('orders.index')->with('success', 'Заказ успешно оплачен!');
        }

        return redirect()->route('orders.index')->with('info', 'Платеж обрабатывается или был отменен.');
    }

    // 2. Метод webhook()
    public function webhook(Request $request, YooKassaPaymentService $yooKassaService): JsonResponse
    {
        // Сервис сам достанет payment_id, запросит API и обновит заказ
        $yooKassaService->handleWebhook($request->all());

        // Всегда отвечаем 200 OK
        return response()->json(['status' => 'success']);
    }

    // 3. Метод create() (нужен, чтобы перенаправить на оплату)
    public function create(Order $order, YooKassaPaymentService $yooKassaService): RedirectResponse
    {
        $payment = $yooKassaService->createPaymentForOrder($order);

        if ($payment->confirmation_url) {
            return redirect($payment->confirmation_url);
        }

        return back()->with('error', 'Не удалось создать платеж');
    }
}
