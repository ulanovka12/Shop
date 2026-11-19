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
            ->with(['items.product', 'latestPayment'])
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

        $order = $service->createOrder(
            $user,
            $request->validated()['payment_method'],
            $cart
        );

        Mail::to(config('mail.admin_address'))
            ->queue(new OrderPlaced($order));

        // Если пользователь выбрал онлайн-оплату, сразу создаю платеж
        if ($order->payment_method === Order::PAYMENT_METHOD_YOOKASSA) {
            $payment = $yooKassaService->createPaymentForOrder($order);

            if ($payment->confirmation_url) {
                return redirect($payment->confirmation_url);
            }

            return redirect()
                ->route('orders.index')
                ->with('error', 'Не удалось создать платеж. Попробуйте позже.');
        }

        return redirect()
            ->route('orders.index')
            ->with('success', 'Заказ создан.');
    }


    public function pay(
        Order $order,
        YooKassaPaymentService $yooKassaService
    ): RedirectResponse {

        if ($order->user_id !== Auth::id()) {
            abort(403, 'Доступ запрещен');
        }

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
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $payments = $order->payments()->latest()->get();

        return view('orders.payments', compact('order', 'payments'));
    }
}
