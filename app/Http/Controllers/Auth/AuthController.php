<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\DTOs\RegisterDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendWelcomeAfterVerificationJob;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
    ) {
    }

    public function showRegistrationForm(): Factory|View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $dto = RegisterDto::fromRequest($request);
        $user = $this
            ->userService
            ->register($dto);

        return redirect()
            ->route('login.form')
            ->with('status', 'Пользователь успешно зарегистрирован');
    }

    public function showLoginForm(): Factory|View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            return redirect()->intended('profile');
        }

        return back()->withErrors(['email' => 'Неверные данные']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }

    public function verifyEmail(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('login.form')->with('status', 'Email уже подтвержден');
        }

        // Помечаем email как подтвержденный
        // Метод вернет true, если подтверждение произошло только что
        if ($request->user()->markEmailAsVerified()) {
            event(new \Illuminate\Auth\Events\Verified($request->user()));

            // ОТПРАВЛЯЕМ ЗАДАЧУ В RABBITMQ (Producer)
            SendWelcomeAfterVerificationJob::dispatch($request->user()->id);
        }

        return redirect()->route('login.form')->with('status', 'Email успешно подтвержден!');
    }

    /**
     * Повторная отправка письма для подтверждения email
     */
    public function resendVerification(Request $request): RedirectResponse
    {
        // Если почта уже подтверждена, просто возвращаем назад
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('profile.edit')->with('status', 'Email уже подтвержден.');
        }

        // Отправляем задачу в RabbitMQ (используем ту же джобу, что и при регистрации)
        \App\Jobs\SendRegistrationVerificationJob::dispatch($request->user()->id);

        return redirect()->route('profile.edit')->with('status', 'Ссылка для подтверждения отправлена на почту!');
    }
}
