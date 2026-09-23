<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Http\Requests\RegisterRequest;
use Spatie\LaravelData\Data;

class RegisterDto extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {
    }

    public static function fromRequest(RegisterRequest $request): self
    {
        return new self(
            $request->validated('name'),
            $request->validated('email'),
            $request->validated('password'),
        );
    }
}
