<?php

declare(strict_types=1);

use App\Http\Requests\Auth\LoginRequest;

class LoginController
{
    public function store(LoginRequest $request)
    {

        $dto = loginDTO::fromRequest($request);

        $this->userService->register($dto);
    }

}
