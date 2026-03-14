<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Order::class;

    public function definition(): array
    {
        $subtotal = $this->faker->numberBetween(2_000_000, 70_000_000);
        $discount = $this->faker->numberBetween(0, 2_000_000);
        $shipping = $this->faker->numberBetween(0, 80_000);
        $tax = (int) round($subtotal * 0.08);

        return [
            'user_id' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
            'address_id' => Address::query()->inRandomOrder()->value('id'),
            'order_code' => 'ORD-' . strtoupper($this->faker->bothify('??######')),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'shipping', 'completed', 'cancelled']),
            'payment_method' => $this->faker->randomElement(['cod', 'stripe', 'paypay', 'bank_transfer']),
            'payment_status' => $this->faker->randomElement(['unpaid', 'paid', 'refunded']),
            'shipping_status' => $this->faker->randomElement(['pending', 'processing', 'shipping', 'delivered']),
            'subtotal' => $subtotal,
            'discount_total' => $discount,
            'shipping_fee' => $shipping,
            'tax_total' => $tax,
            'grand_total' => max(0, $subtotal - $discount + $shipping + $tax),
            'customer_note' => $this->faker->optional()->sentence(),
            'placed_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
