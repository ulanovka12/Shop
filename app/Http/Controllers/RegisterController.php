<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTOs\RegisterDto;
use App\Http\Requests\Auth\RegisterRequest;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request)
    {
        // Преобразуем реквест в DTO
        $dto = RegisterDto::fromRequest($request);

        // Передаём DTO в сервис
        $this->userService->register($dto);
    }
}
