<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\DTOs\RegisterDto;

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
