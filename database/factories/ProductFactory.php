<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

/**
 * @extends Factory<Product>
 */


class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $seed = Str::uuid()->toString();
        $url  = "https://picsum.photos/seed/{$seed}/400/300";

        $path = 'products/' . $seed . '.jpg';

        try {
            $contents = Http::timeout(10)->get($url)->body();
            Storage::disk('public')->put($path, $contents);
        } catch (\Throwable $e) {
            $path = null; // интернета нет — оставим null, сработает заглушка
        }

        return [
            'name'        => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'price'       => $this->faker->randomFloat(2, 100, 100000),
            'stock'       => $this->faker->numberBetween(0, 500),
            'is_active'   => $this->faker->boolean(80),
            'image'       => $path,   // хранится относительный путь: products/uuid.jpg
        ];
    }
}
