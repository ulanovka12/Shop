<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class SearchDemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Создаем категории
        $laptops = Category::updateOrCreate(
            ['slug' => 'search-demo-laptops'],
            ['name' => 'Ноутбуки']
        );

        $phones = Category::updateOrCreate(
            ['slug' => 'search-demo-phones'],
            ['name' => 'Смартфоны']
        );

        // 2. Создаем товары
        $products = [
            [
                'sku' => 'SEARCH-DEMO-LENOVO',
                'name' => 'Ноутбук Lenovo ThinkPad',
                'price' => 79990.00,
                'stock' => 5,
                'category_id' => $laptops->id,
            ],
            [
                'sku' => 'SEARCH-DEMO-ASUS',
                'name' => 'Ноутбук ASUS ZenBook',
                'price' => 89990.00,
                'stock' => 0,
                'category_id' => $laptops->id,
            ],
            [
                'sku' => 'SEARCH-DEMO-MACBOOK',
                'name' => 'Ноутбук Apple MacBook Air',
                'price' => 119990.00,
                'stock' => 3,
                'category_id' => $laptops->id,
            ],
            [
                'sku' => 'SEARCH-DEMO-IPHONE',
                'name' => 'Смартфон Apple iPhone 15',
                'price' => 69990.00,
                'stock' => 10,
                'category_id' => $phones->id,
            ],
            [
                'sku' => 'SEARCH-DEMO-SAMSUNG',
                'name' => 'Смартфон Samsung Galaxy S24',
                'price' => 74990.00,
                'stock' => 4,
                'category_id' => $phones->id,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['sku' => $product['sku']],
                $product
            );
        }
    }
}
