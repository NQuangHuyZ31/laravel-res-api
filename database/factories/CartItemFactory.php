<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartItem>
 */
class CartItemFactory extends Factory
{
    protected $model = CartItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = fake()->numberBetween(250_000, 35_000_000);

        return [
            'cart_id' => Cart::query()->inRandomOrder()->value('id') ?? Cart::factory(),
            'product_id' => Product::query()->inRandomOrder()->value('id') ?? Product::factory(),
            'product_variant_id' => ProductVariant::query()->inRandomOrder()->value('id'),
            'quantity' => fake()->numberBetween(1, 3),
            'unit_price' => $price,
        ];
    }
}
