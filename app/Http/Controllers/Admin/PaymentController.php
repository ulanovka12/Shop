<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderPayment;
use Illuminate\Contracts\View\View;

class PaymentController extends Controller
{
    public function index(): View
    {
        $payments = OrderPayment::with(['order.user'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.payments.index', [
            'payments' => $payments,
        ]);
    }
}
