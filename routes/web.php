<?php

declare(strict_types=1);

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YooKassaController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Admin\PaymentController;

Route::middleware('guest')->group(function () {
    // registration
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    // login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::middleware('auth')->group(function () {
    // logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    // profile
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.form');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/email/verification-notification', [AuthController::class, 'resendVerification'])
        ->middleware(['auth', 'throttle:6,1'])
        ->name('verification.send');

    //Address
    Route::post('/addresses', [AddressController::class, 'store'])     ->name('addresses.store');
    Route::patch('/addresses/{address}/default', [AddressController::class, 'setDefault'])->name('addresses.default');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])   ->name('addresses.destroy');

    // password
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.form');
    Route::post('/change-password', [AuthController::class, 'updatePassword'])->name('password.update');

    Route::get('/products/{product}', [ProductController::class, 'show'])
        ->name('products.show');
    Route::view('/', 'main')->name('home');


    Route::get('/categories', [CategoryController::class, 'index'])
        ->name('categories.index');

    Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])
        ->name('categories.show');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/items/{product}', [CartController::class, 'store'])->name('cart.items.store');
    Route::patch('/cart/items/{product}', [CartController::class, 'update'])->name('cart.items.update');
    Route::delete('/cart/items/{product}', [CartController::class, 'destroy'])->name('cart.items.destroy');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    //Orders
    Route::middleware('auth')->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])
            ->name('orders.status.update');
    });



    //Admin
    // 1. Дашборд
    Route::get('/admin', [DashboardController::class, 'index'])
        ->middleware(['auth', 'role:admin'])
        ->name('admin.dashboard');

    // 2. Платежи
    Route::get('/admin/payments', [PaymentController::class, 'index'])
        ->middleware(['auth', 'role:admin'])
        ->name('admin.payments.index');

    // 3. Роли (Resource)
    Route::resource('/admin/roles', RoleController::class)
        ->except(['show'])
        ->middleware(['auth', 'role:admin'])
        ->names('admin.roles'); // Указываем префикс для имен роутов вручную

    // 4. Товары (Resource)
    Route::resource('/admin/products', AdminProductController::class)
        ->whereNumber('product')
        ->middleware(['auth', 'role:admin'])
        ->names('admin.products'); // Указываем префикс для имен роутов вручную
    // 5. История Платежных попыток для пользователя
    Route::get('/orders/{order}/payments', [OrderController::class, 'paymentHistory'])->name('orders.payments');

    //Страница с просьбой проверить почту!
    Route::get('/email/verify', function () {
        return view('auth.verify-email'); // Вам нужно будет создать этот view
    })->middleware('auth')->name('verification.notice');

    //Обработка ссылки из письма (тут мы и вызовем наш Producer)
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
        ->middleware(['auth', 'signed'])
        ->name('verification.verify');

    // 1. Создание платежа (когда пользователь нажимает "Оплатить картой")
    Route::post('/payments/yookassa/create/{order}', [YooKassaController::class, 'create'])
        ->middleware('auth')
        ->name('payments.yookassa.create');

    // 2. Webhook (сюда ЮKassa будет присылать уведомления об оплате)
    Route::post('/payments/yookassa/webhook', [YooKassaController::class, 'webhook'])
        ->name('payments.yookassa.webhook');

    // 3. Return URL (сюда ЮKassa вернет пользователя после оплаты)
    Route::get('/payments/yookassa/return/{order}', [YooKassaController::class, 'return'])
        ->middleware('auth')
        ->name('payments.yookassa.return');

    Route::post('/orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');
});
