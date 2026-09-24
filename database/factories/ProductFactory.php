<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'category_id' => Category::query()->inRandomOrder()->value('id'),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 100, 100000),
            'stock' => $this->faker->numberBetween(0, 500),
            'is_active' => $this->faker->boolean(80),
            'image' => $this->copyRandomImage(),
        ];
    }

    private function copyRandomImage(): ?string
    {
        $sourceDir = database_path('seeders/images/products');

        if (!File::isDirectory($sourceDir)) {
            return null;
        }

        $files = File::files($sourceDir);

        if (empty($files)) {
            return null;
        }

        $file = $files[array_rand($files)];
        $path = 'products/' . Str::uuid() . '.jpg';

        $manager = new ImageManager(new Driver());

        $image = $manager
            ->decode($file->getPathname())   // в v4 — decode, а не read
            ->cover(400, 400);

        $encoded = $image->encodeUsingFileExtension('jpg', quality: 85);

        Storage::disk('public')->put($path, (string)$encoded);

        return $path;
    }
}
