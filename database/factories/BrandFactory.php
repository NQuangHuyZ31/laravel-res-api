<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    protected $model = Brand::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->company() . ' Tech';

        return [
            'name' => $name,
            'slug' => fake()->unique()->slug(),
            'country' => fake()->country(),
            'description' => fake()->sentence(12),
            'is_active' => true,
        ];
    }
}
