<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Http\Requests\ProductFilterRequest;
use Spatie\LaravelData\Data;

class ProductFilterDto extends Data
{
    public function __construct(
        public ?string $q,
        public ?int $min_price,
        public ?int $max_price,
        public bool $in_stock,
        public string $sort,
        public int $per_page,
    ) {
    }

    public static function fromRequest(ProductFilterRequest $request): self
    {
        $validated = $request->validated();

        return new self(
            q: $validated['q'] ?? null,
            min_price: isset($validated['min_price']) ? (int) $validated['min_price'] : null,
            max_price: isset($validated['max_price']) ? (int) $validated['max_price'] : null,

            // boolean() удобно для чекбоксов: вернёт true/false
            in_stock: $request->boolean('in_stock'),

            // Дефолты
            sort: $validated['sort'] ?? 'new',
            per_page: isset($validated['per_page']) ? (int) $validated['per_page'] : 10,
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            q:         $data['q'] ?? null,
            min_price: isset($data['min_price']) ? (int) $data['min_price'] : null,
            max_price: isset($data['max_price']) ? (int) $data['max_price'] : null,
            in_stock:  filter_var($data['in_stock'] ?? false, FILTER_VALIDATE_BOOLEAN),
            sort:      $data['sort'] ?? 'new',
            per_page:  isset($data['per_page']) ? (int) $data['per_page'] : 10,
        );
    }
}
