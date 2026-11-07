<?php

namespace App\Mail;

use App\Models\PaymentReceipt;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReceiptFailedNotification extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public PaymentReceipt $receipt)
    {
    }

    public function build()
    {
        return $this->subject('Внимание: Чек не зарегистрирован в ЮKassa!')
            ->view('emails.admin.receipt-failed');
    }
    public function content(): Content
    {
        return new Content(view: 'emails.admin.receipt-failed');
    }
}
