<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {

        $roots = [
            'Электроника'    => 'Смартфоны, ноутбуки, гаджеты',
            'Одежда'         => 'Мужская и женская одежда',
            'Дом и сад'      => 'Товары для дома, инструменты',
            'Спорт'          => 'Спортинвентарь и экипировка',
            'Книги'          => 'Художественная и учебная литература',
        ];

        foreach ($roots as $name => $description) {
            $parent = Category::create([
                'name'        => $name,
                'slug'        => Str::slug($name),
                'description' => $description,
                'is_active'   => true,
            ]);

            // 2–4 подкатегории на каждую корневую
            Category::factory()
                ->count(random_int(2, 4))
                ->childOf($parent)
                ->create();
        }
    }
}
