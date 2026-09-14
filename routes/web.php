<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

include base_path('routes/auth.php');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
require __DIR__.'/auth.php';


