<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTOs\ProductFilterDto;
use App\Http\Requests\ProductFilterRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        private readonly ProductService $productService,
    ) {
    }

    public function index(): View
    {
        $categories = Category::query()
            ->withCount('products')
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function show(Category $category, ProductFilterRequest $request)
    {
        $filter = ProductFilterDto::fromRequest($request);

        $query = Product::where('category_id', $category->id);

        // Максимальная цена среди товаров этой категории — для слайдера/фильтра
        $maxProductPrice = (clone $query)->max('price') ?? 0;

        $products = $query->paginate($filter->per_page)->withQueryString();

        return view('products.index', compact(
            'category',
            'products',
            'filter',
            'maxProductPrice',
        ));
    }
}
