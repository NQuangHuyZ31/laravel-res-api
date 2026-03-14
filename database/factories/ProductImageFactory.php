<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductImage>
 */
class ProductImageFactory extends Factory
{
    protected $model = ProductImage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::query()->inRandomOrder()->value('id') ?? Product::factory(),
            'product_variant_id' => null,
            'image_url' => fake()->imageUrl(1200, 1200, 'technics'),
            'alt_text' => fake()->words(4, true),
            'sort_order' => fake()->numberBetween(0, 10),
            'is_primary' => fake()->boolean(20),
        ];
    }
}
