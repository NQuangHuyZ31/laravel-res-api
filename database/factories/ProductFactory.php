<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = ucfirst(fake()->words(3, true));
        $basePrice = fake()->numberBetween(1_500_000, 55_000_000);
        $salePrice = fake()->boolean(60) ? $basePrice - fake()->numberBetween(100_000, 2_000_000) : null;

        return [
            'brand_id' => Brand::query()->inRandomOrder()->value('id') ?? Brand::factory(),
            'category_id' => Category::query()->inRandomOrder()->value('id') ?? Category::factory(),
            'name' => $name,
            'slug' => fake()->unique()->slug(),
            'sku' => strtoupper(fake()->unique()->bothify('PRD-###??')),
            'product_type' => fake()->randomElement(['simple', 'configurable']),
            'description' => fake()->paragraph(3),
            'base_price' => $basePrice,
            'sale_price' => $salePrice,
            'weight_gram' => fake()->numberBetween(100, 4500),
            'specifications' => json_encode([
                'cpu' => fake()->randomElement(['Intel Core i5', 'Intel Core i7', 'Apple M2', 'Snapdragon 8 Gen 2']),
                'ram' => fake()->randomElement(['8GB', '16GB', '32GB']),
                'storage' => fake()->randomElement(['256GB SSD', '512GB SSD', '1TB SSD']),
                'color' => fake()->randomElement(['Black', 'Silver', 'Blue', 'Gray']),
            ]),
            'view_count' => fake()->numberBetween(0, 8000),
            'is_featured' => fake()->boolean(25),
            'is_active' => true,
        ];
    }
}
