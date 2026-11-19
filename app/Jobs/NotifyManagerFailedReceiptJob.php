<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\ReceiptFailedNotification;
use App\Models\PaymentReceipt;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class NotifyManagerFailedReceiptJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public PaymentReceipt $receipt
    ) {
        $this->onQueue('admin.notifications');
    }

    public function handle(): void
    {
        Mail::to(config('mail.admin_address'))->send(new ReceiptFailedNotification($this->receipt));
    }
}
