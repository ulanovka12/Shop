<?php

declare(strict_types=1);

namespace App\DTOs;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ProductDto
{
    public function __construct(
        public readonly string $name,
        public readonly float $price,
        public readonly int $stock,
        public readonly string $sku,
        public readonly bool $is_active = false,
        public readonly ?int $categoryId = null,
        public readonly ?UploadedFile $image = null,
        public readonly ?string $description = null,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            name:       $request->input('name'),
            price:      (float) $request->input('price'),
            stock:      (int) $request->input('stock'),
            sku:        $request->input('sku'),
            is_active:   (bool)$request->input('is_active'),
            categoryId: $request->input('category_id'),
            image:      $request->file('image'),
            description: $request->input('description'),
        );
    }

    public function toProductData(): array
    {
        return [
            'name'        => $this->name,
            'price'       => $this->price,
            'stock'       => $this->stock,
            'sku'         => $this->sku,
            'is_active'      => $this->is_active,
            'category_id' => $this->categoryId,
            'description' => $this->description,
        ];
    }
}
