<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    protected $model = ProductVariant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = fake()->numberBetween(1_300_000, 60_000_000);

        return [
            'product_id' => Product::query()->inRandomOrder()->value('id') ?? Product::factory(),
            'name' => fake()->randomElement(['Base', 'Standard', 'Pro', 'Ultra']),
            'sku' => strtoupper(fake()->unique()->bothify('VAR-###??')),
            'attributes' => json_encode([
                'color' => fake()->randomElement(['Black', 'Silver', 'Blue']),
                'ram' => fake()->randomElement(['8GB', '16GB']),
                'storage' => fake()->randomElement(['256GB', '512GB']),
            ]),
            'price' => $price,
            'sale_price' => fake()->boolean(50) ? $price - fake()->numberBetween(100_000, 1_500_000) : null,
            'stock_quantity' => fake()->numberBetween(0, 300),
            'low_stock_threshold' => fake()->numberBetween(3, 12),
            'is_default' => fake()->boolean(20),
            'is_active' => true,
        ];
    }
}
