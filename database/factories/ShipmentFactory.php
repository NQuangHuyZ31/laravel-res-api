<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shipment>
 */
class ShipmentFactory extends Factory
{
    protected $model = Shipment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::query()->inRandomOrder()->value('id') ?? Order::factory(),
            'carrier' => fake()->randomElement(['Giao Hang Nhanh', 'Giao Hang Tiet Kiem', 'Viettel Post']),
            'tracking_number' => strtoupper(fake()->unique()->bothify('TRK########')),
            'status' => fake()->randomElement(['pending', 'shipping', 'delivered', 'failed']),
            'shipped_at' => fake()->optional(0.7)->dateTimeBetween('-1 month', 'now'),
            'delivered_at' => fake()->optional(0.5)->dateTimeBetween('-1 month', 'now'),
            'shipping_note' => fake()->optional()->sentence(),
        ];
    }
}
