<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTOs\ProductDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(StoreProductRequest $request, ProductService $service)
    {
        $service->create(ProductDto::fromRequest($request));
        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Товар создан');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));

    }
    public function update(UpdateProductRequest $request, Product $product, ProductService $service)
    {
        $service->update($product, ProductDto::fromRequest($request));
        return redirect()->route('admin.products.index')->with('success', 'Товар обновлён');
    }

    public function destroy(Product $product, ProductService $service)
    {
        $service->delete($product);
        return redirect()->route('admin.products.index')->with('success', 'Товар удалён');
    }
}
