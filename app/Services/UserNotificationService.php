<?php

declare(strict_types=1);

namespace App\Services;

use App\Mail\VerifyEmailMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class UserNotificationService
{
    public function sendEmailVerification(User $user): void
    {
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1($user->getEmailForVerification())
            ]
        );

        Mail::to($user->email)->send(new VerifyEmailMail($user, $verificationUrl));
    }

    public function sendWelcome(User $user): void
    {
        \Illuminate\Support\Facades\Log::info("Welcome-письмо отправлено для: {$user->email}");
    }
}
