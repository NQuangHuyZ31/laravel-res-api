<?php

namespace Database\Factories;

use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CouponUsage>
 */
class CouponUsageFactory extends Factory
{
    protected $model = CouponUsage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'coupon_id' => Coupon::query()->inRandomOrder()->value('id') ?? Coupon::factory(),
            'user_id' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
            'order_id' => Order::query()->inRandomOrder()->value('id') ?? Order::factory(),
            'discount_amount' => fake()->numberBetween(20_000, 500_000),
        ];
    }
}
