<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 3);
        $unitPrice = fake()->numberBetween(300_000, 40_000_000);

        return [
            'order_id' => Order::query()->inRandomOrder()->value('id') ?? Order::factory(),
            'product_id' => Product::query()->inRandomOrder()->value('id') ?? Product::factory(),
            'product_variant_id' => ProductVariant::query()->inRandomOrder()->value('id'),
            'product_name' => fake()->words(3, true),
            'variant_name' => fake()->optional()->randomElement(['Standard', 'Pro', 'Ultra']),
            'sku' => strtoupper(fake()->bothify('SKU-###??')),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'line_total' => $quantity * $unitPrice,
        ];
    }
}
