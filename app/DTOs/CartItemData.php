<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Models\Product;
use Illuminate\Http\Request;

final readonly class CartItemData
{
    public function __construct(
        public int $productId,
        public int $quantity,
    ) {
    }

    public static function fromRequest(Request $request, Product $product): self
    {
        return new self(
            productId: $product->id,
            quantity: (int) $request->input('quantity', 1),
        );
    }
}
