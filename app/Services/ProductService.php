<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\ProductDto;
use App\DTOs\ProductFilterDto;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    private const CATALOG_CACHE_TTL = 600;

    private const CATALOG_VERSION_KEY = 'products:catalog:version';

    public function getProducts(ProductFilterDto $dto): LengthAwarePaginator
    {
        $params = $this->getFilterParams($dto);
        $key = $this->getCacheKey('catalog', $params);


        $paginator = Cache::remember($key, self::CATALOG_CACHE_TTL, function () use ($dto) {
            $query = $this->applyFilters(Product::query(), $dto);
            return $query->paginate($dto->per_page);
        });

        return $paginator->withQueryString();
    }

    public function getProductsByCategoryId(int $categoryId, ProductFilterDto $dto): LengthAwarePaginator
    {
        $params = $this->getFilterParams($dto);
        $params['category_id'] = $categoryId;
        $key = $this->getCacheKey('category', $params);

        $paginator = Cache::remember($key, self::CATALOG_CACHE_TTL, function () use ($categoryId, $dto) {
            $query = Product::query()
                ->where('category_id', $categoryId)
                ->with('category');

            $query = $this->applyFilters($query, $dto);

            return $query->paginate($dto->per_page);
        });

        return $paginator->withQueryString();
    }

    private function applyFilters(Builder $query, ProductFilterDto $dto): Builder
    {
        if ($dto->q) {
            $q = $dto->q;
            $query->where(function ($subQuery) use ($q) {
                $subQuery
                    ->where('name', 'like', '%' . $q . '%')
                    ->orWhere('sku', 'like', '%' . $q . '%');
            });
        }

        if ($dto->min_price !== null) {
            $query->where('price', '>=', $dto->min_price);
        }
        if ($dto->max_price !== null) {
            $query->where('price', '<=', $dto->max_price);
        }

        if ($dto->in_stock) {
            $query->where('stock', '>', 0);
        }

        switch ($dto->sort) {
            case 'price_asc':  $query->orderBy('price', 'asc');
                break;
            case 'price_desc': $query->orderBy('price', 'desc');
                break;
            case 'name_asc':   $query->orderBy('name', 'asc');
                break;
            case 'name_desc':  $query->orderBy('name', 'desc');
                break;
            case 'stock_asc':  $query->orderBy('stock', 'asc');
                break;
            case 'stock_desc': $query->orderBy('stock', 'desc');
                break;
            case 'new':
            default:           $query->orderByDesc('created_at');
                break;
        }

        $query->orderByDesc('id');

        return $query;
    }

    public function getMaxProductPrice(): int
    {
        $key = 'products:max_price:v' . $this->getCatalogVersion();

        return (int) Cache::remember($key, self::CATALOG_CACHE_TTL, function () {
            return Product::query()->max('price') ?? 0;
        });
    }

    public function create(ProductDto $dto): Product
    {
        $data = $dto->toProductData();

        if ($dto->image) {
            $data['image'] = $dto->image->store('products', 'public');
        }

        $product = Product::create($data);
        $this->invalidateCatalogCache();

        return $product;
    }

    public function update(Product $product, ProductDto $dto): Product
    {
        $data = $dto->toProductData();

        if ($dto->image) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $dto->image->store('products', 'public');
        }

        $product->update($data);
        $this->invalidateCatalogCache();

        return $product;
    }

    public function delete(Product $product): void
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        $this->invalidateCatalogCache();
    }

    private function getCatalogVersion(): int
    {
        if (!Cache::has(self::CATALOG_VERSION_KEY)) {
            Cache::forever(self::CATALOG_VERSION_KEY, 1);
        }

        return (int) Cache::get(self::CATALOG_VERSION_KEY);
    }

    public function invalidateCatalogCache(): void
    {
        Cache::increment(self::CATALOG_VERSION_KEY);
    }

    private function getCacheKey(string $prefix, array $params): string
    {
        $version = $this->getCatalogVersion();
        $hash = hash('sha256', json_encode($params));

        return "products:{$prefix}:v{$version}:{$hash}";
    }

    private function getFilterParams(ProductFilterDto $dto): array
    {
        return [
            'page' => (int) request()->input('page', 1),
            'per_page' => $dto->per_page,
            'q' => $dto->q,
            'min_price' => $dto->min_price,
            'max_price' => $dto->max_price,
            'in_stock' => $dto->in_stock,
            'sort' => $dto->sort,
        ];
    }
}
