<?php

namespace Database\Factories;

use App\Models\InventoryTransaction;
use App\Models\Order;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InventoryTransaction>
 */
class InventoryTransactionFactory extends Factory
{
    protected $model = InventoryTransaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['import', 'adjustment', 'sale', 'return']);
        $quantityChange = match ($type) {
            'sale' => -1 * fake()->numberBetween(1, 3),
            default => fake()->numberBetween(1, 15),
        };

        return [
            'product_variant_id' => ProductVariant::query()->inRandomOrder()->value('id') ?? ProductVariant::factory(),
            'order_id' => $type === 'sale' ? (Order::query()->inRandomOrder()->value('id') ?? Order::factory()) : null,
            'transaction_type' => $type,
            'quantity_change' => $quantityChange,
            'reference_type' => fake()->optional()->randomElement(['purchase_order', 'manual_adjustment', 'customer_order']),
            'reference_code' => strtoupper(fake()->optional()->bothify('REF-######')),
            'note' => fake()->optional()->sentence(),
        ];
    }
}
