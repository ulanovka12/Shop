<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);

        return [
            'name'        => Str::title($name),
            'slug'        => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1, 99999),
            'description' => $this->faker->sentence(),
            'parent_id'   => null,
            'is_active'   => true,
            'sort_order'  => $this->faker->numberBetween(0, 100),
        ];
    }

    /** Дочерняя категория с родителем. */
    public function childOf(Category $parent): static
    {
        return $this->state(fn () => [
            'parent_id' => $parent->id,
        ]);
    }

    /** Неактивная категория. */
    public function inactive(): static
    {
        return $this->state(fn () => [
            'is_active' => false,
        ]);
    }
}
