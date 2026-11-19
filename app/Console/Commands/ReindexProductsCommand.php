<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\ProductSearchService;
use Illuminate\Console\Command;

class ReindexProductsCommand extends Command
{
    protected $signature = 'products:reindex {--batch=500}';
    protected $description = 'Полная переиндексация товаров в Elasticsearch';

    public function handle(ProductSearchService $search): int
    {
        $batch = (int) $this->option('batch');

        try {
            $count = $search->reindex($batch);
            $this->info("Проиндексировано товаров: {$count}. Поисковый alias переключён.");
            return 0;
        } catch (\Throwable $e) {
            $this->error("Индексация не завершена: " . $e->getMessage());
            return 1;
        }
    }
}
