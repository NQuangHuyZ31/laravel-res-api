<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
            'recipient_name' => fake()->name(),
            'recipient_phone' => fake()->numerify('09########'),
            'country' => 'Vietnam',
            'city' => fake()->randomElement(['Ho Chi Minh', 'Ha Noi', 'Da Nang', 'Can Tho']),
            'district' => fake()->citySuffix(),
            'ward' => fake()->optional()->streetSuffix(),
            'street_address' => fake()->streetAddress(),
            'postal_code' => fake()->optional()->postcode(),
            'is_default' => false,
        ];
    }
}
