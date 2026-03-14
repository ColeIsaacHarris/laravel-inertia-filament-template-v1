<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PoItem>
 */
class PoItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => fake()->sentence(),
            'quantity' => fake()->numberBetween(1, 50),
            'unit' => 'slab',
            'unit_price_cents' => fake()->numberBetween(10000, 500000),
            'line_total_cents' => fake()->numberBetween(50000, 2500000),
        ];
    }
}
