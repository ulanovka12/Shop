<?php

namespace App\Http\Controllers\Auth;

use App\DTO\RegisterDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Service\UserService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserService $service
    ) {}

    public function showLoginForm(): Factory|View
    {
        return view('auth.login');
    }

    /** Показ формы регистрации */
    public function showRegistrationForm(): Factory|View
    {
        return view('auth.register');
    }

    /** Обработка регистрации */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $dto = RegisterDto::fromRequest($request);
        $user = $this->service->register($dto);

        Auth::login($user);

        return redirect()
            ->route('login.form')
            ->with('status', 'Регистрация прошла успешно');
    }
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return back()->withErrors([
            'email' => 'Неверный email или пароль',
        ])->onlyInput('email');
    }
}
