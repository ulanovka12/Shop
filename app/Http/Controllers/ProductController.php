<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTOs\ProductFilterDto;
use App\Http\Requests\ProductFilterRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService,
    ) {}

    public function index(ProductFilterRequest $request): View
    {
        $dto = ProductFilterDto::fromRequest($request);

        return view('products.index', [
            'products' => $this->productService->getProducts($dto),
        ]);
    }

    public function show(Product $product)
    {
        $data = $this->productService->getProductPageData($product);

        return view('products.show', $data);
    }
}
