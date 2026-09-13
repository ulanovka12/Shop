<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;
use App\Http\Requests\Auth\RegisterRequest;

class RegisterDto extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}

    public static function fromRequest(RegisterRequest $request): self
    {
        return new self(
            $request->validated('name'),
            $request->validated('email'),
            $request->validated('password'),
        );
    }
}
