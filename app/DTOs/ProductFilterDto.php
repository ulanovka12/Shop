<?php

declare(strict_types=1);

namespace App\DTOs;

final readonly class ProductFilterDto
{
    public function __construct(
        public ?int $per_page = null,
    ) {}

    public static function fromRequest(\App\Http\Requests\ProductFilterRequest $request): self
    {
        return new self(
            per_page: $request->validated('per_page') !== null
                ? (int) $request->validated('per_page')
                : null,
        );
    }
}
