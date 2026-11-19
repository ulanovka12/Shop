<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\DTOs\ProductFilterDto;
use App\Services\ProductSearchService;
use Illuminate\Console\Command;

class SearchProductsCommand extends Command
{
    protected $signature = 'products:search
                            {query : Поисковый запрос}
                            {--category= : ID категории}
                            {--min-price= : Минимальная цена}
                            {--max-price= : Максимальная цена}
                            {--in-stock : Только в наличии}
                            {--sort= : Сортировка}
                            {--per-page=10 : Товаров на странице}
                            {--page=1 : Номер страницы}';

    protected $description = 'Поиск товаров через Elasticsearch';

    public function handle(ProductSearchService $search): int
    {
        // Исправленное создание DTO с учетом ваших обязательных параметров
        $dto = new ProductFilterDto(
            q: $this->argument('query'),
            min_price: $this->option('min-price') !== null ? (int)$this->option('min-price') : null,
            max_price: $this->option('max-price') !== null ? (int)$this->option('max-price') : null,
            in_stock: (bool)$this->option('in-stock'),
            sort: $this->option('sort') ?? 'new',
            per_page: (int)$this->option('per-page')
        );

        try {

            $paginator = $search->search(
                $dto,
                $dto->per_page,
                $this->option('category') ? (int)$this->option('category') : null,
                (int)$this->option('page')
            );

            $this->info("Найдено: {$paginator->total()}. Страница: {$paginator->currentPage()}.");

            $rows = [];
            foreach ($paginator->items() as $product) {
                $rows[] = [
                    $product->id,
                    $product->name,
                    $product->sku,
                    $product->price,
                    $product->stock,
                ];
            }

            if (empty($rows)) {
                $this->warn("Ничего не найдено.");
            } else {
                $this->table(['ID', 'Название', 'Артикул', 'Цена', 'Остаток'], $rows);
            }

            return 0;
        } catch (\Throwable $e) {
            $this->error("Ошибка поиска: " . $e->getMessage());
            return 1;
        }
    }
}
