<?php

namespace Database\Factories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    protected $model = Coupon::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['fixed', 'percent']);

        return [
            'code' => strtoupper(fake()->unique()->bothify('SALE##??')),
            'name' => ucfirst(fake()->words(3, true)),
            'discount_type' => $type,
            'discount_value' => $type === 'fixed'
                ? fake()->numberBetween(20_000, 400_000)
                : fake()->numberBetween(5, 25),
            'minimum_order_amount' => fake()->numberBetween(0, 5_000_000),
            'maximum_discount_amount' => $type === 'percent' ? fake()->numberBetween(100_000, 1_000_000) : null,
            'usage_limit' => fake()->numberBetween(100, 1000),
            'used_count' => 0,
            'starts_at' => now()->subDays(fake()->numberBetween(1, 15)),
            'expires_at' => now()->addDays(fake()->numberBetween(30, 180)),
            'is_active' => true,
        ];
    }
}
