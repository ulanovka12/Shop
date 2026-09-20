<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class UpdateProfileDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $password = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            name:     $request->string('name')->toString(),
            email:    $request->string('email')->toString(),
            password: $request->filled('password')
                ? $request->string('password')->toString()
                : null,
        );
    }
}
