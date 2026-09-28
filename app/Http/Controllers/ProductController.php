<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTOs\ProductFilterDto;
use App\Http\Requests\ProductFilterRequest;
use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService,
    ) {
    }

    public function index(ProductFilterRequest $request)
    {
        $dto = ProductFilterDto::fromRequest($request);

        $products = $this->productService->getProducts($dto);

        $maxProductPrice = $this->productService->getMaxProductPrice();

        return view('products.index', compact('products', 'dto', 'maxProductPrice'));
    }

    public function show(Product $product)
    {
        // Страница товара — отдельный урок, здесь оставляем как есть
        return view('products.show', compact('product'));
    }
}
