<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::query()->inRandomOrder()->value('id') ?? Order::factory(),
            'provider' => fake()->randomElement(['cod', 'stripe', 'paypay', 'bank_transfer']),
            'transaction_code' => strtoupper(fake()->unique()->bothify('TXN-########')),
            'amount' => fake()->numberBetween(500_000, 60_000_000),
            'status' => fake()->randomElement(['pending', 'paid', 'failed', 'refunded']),
            'paid_at' => fake()->optional(0.7)->dateTimeBetween('-2 months', 'now'),
            'meta' => json_encode([
                'bank' => fake()->optional()->randomElement(['VCB', 'ACB', 'MB']),
            ]),
        ];
    }
}
