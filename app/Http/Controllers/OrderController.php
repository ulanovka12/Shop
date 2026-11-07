<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\OrderStatusRequest;
use App\Http\Requests\OrderStoreRequest;
use App\Mail\OrderPlaced;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\SessionCartService;
use App\Services\YooKassaPaymentService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class OrderController
{
    public function index(): Factory|View
    {
        $orders = Order::query()
            ->where('user_id', Auth::id())
            ->with(['items.product', 'latestPayment']) // Добавили загрузку последнего платежа для отображения статуса
            ->orderByDesc('created_at')
            ->get();

        return view('orders.index', [
            'orders' => $orders,
        ]);
    }

    public function store(
        OrderStoreRequest $request,
        OrderService $service,
        SessionCartService $cart,
        YooKassaPaymentService $yooKassaService
    ): RedirectResponse {
        $user = Auth::user();

        // 1. Сохраняем результат в $order
        $order = $service->createOrder(
            $user,
            $request->validated()['payment_method'],
            $cart
        );

        // 2. Ставим письмо в очередь (для админа)
        Mail::to(config('mail.admin_address'))
            ->queue(new OrderPlaced($order));

        // 3. ЛОГИКА ДЛЯ ЮKASSA:
        // Если пользователь выбрал онлайн-оплату, сразу создаем платеж
        if ($order->payment_method === Order::PAYMENT_METHOD_YOOKASSA) {
            $payment = $yooKassaService->createPaymentForOrder($order);

            // Если ЮKassa вернула ссылку на оплату — перенаправляем туда
            if ($payment->confirmation_url) {
                return redirect($payment->confirmation_url);
            }

            // Если ссылки нет (ошибка), возвращаем назад с сообщением
            return redirect()
                ->route('orders.index')
                ->with('error', 'Не удалось создать платеж. Попробуйте позже.');
        }

        // Если оплата наличными — просто показываем список заказов
        return redirect()
            ->route('orders.index')
            ->with('success', 'Заказ создан.');
    }

    /**
     * Новый метод pay() для повторной оплаты из списка "Мои заказы"
     */
    public function pay(
        Order $order,
        YooKassaPaymentService $yooKassaService
    ): RedirectResponse {
        // Проверяем, что заказ принадлежит текущему пользователю
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Доступ запрещен');
        }

        // Проверяем, что заказ еще не оплачен и ожидает оплаты
        if ($order->status !== Order::STATUS_PENDING) {
            return back()->with('error', 'Этот заказ не требует оплаты.');
        }

        // Создаем новую попытку оплаты
        $payment = $yooKassaService->createPaymentForOrder($order);

        if ($payment->confirmation_url) {
            return redirect($payment->confirmation_url);
        }

        return back()->with('error', 'Не удалось создать платеж. Попробуйте позже.');
    }

    public function updateStatus(
        Order $order,
        OrderStatusRequest $request,
        OrderService $service
    ): RedirectResponse {
        $order = Order::query()
            ->where('user_id', Auth::id())
            ->whereKey($order->id)
            ->firstOrFail();

        $status = $request->validated()['status'];

        if ($status === Order::STATUS_PAID) {
            $service->markAsPaid($order);
            $message = 'Заказ оплачен.';
        } else {
            $service->cancel($order);
            $message = 'Заказ отменен.';
        }

        return redirect()
            ->route('orders.index')
            ->with('success', $message);
    }

    public function paymentHistory(Order $order)
    {
        // Проверка, что заказ принадлежит пользователю
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $payments = $order->payments()->latest()->get();

        return view('orders.payments', compact('order', 'payments'));
    }
}
