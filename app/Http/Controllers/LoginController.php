<?php

use App\Http\Requests\Auth\LoginRequest;

class LoginController
{

    public function store(LoginRequest $request)
    {
        // Преобразуем реквест в DTO
        $dto = loginDTO::fromRequest($request);

        // Передаём DTO в сервис
        $this->userService->register($dto);
    }

}
