<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\ProductSearchService;
use Illuminate\Console\Command;

class IndexProductCommand extends Command
{
    protected $signature = 'products:index {id}';
    protected $description = 'Обновить или удалить один товар в поисковом индексе';

    public function handle(ProductSearchService $search): int
    {
        $id = (int) $this->argument('id');

        try {
            $search->sync($id);
            $this->info("Товар {$id} синхронизирован.");
            return 0;
        } catch (\Throwable $e) {
            $this->error("Ошибка синхронизации: " . $e->getMessage());
            return 1;
        }
    }
}
