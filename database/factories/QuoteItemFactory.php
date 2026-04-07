<?php

namespace Database\Factories;

use App\Models\QuoteItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuoteItem>
 */
class QuoteItemFactory extends Factory
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
            'quantity' => fake()->numberBetween(1, 10),
            'unit_price_cents' => fake()->numberBetween(10000, 500000),
            'line_total_cents' => fake()->numberBetween(10000, 5000000),
            'sort_order' => fake()->numberBetween(1, 20),
        ];
    }
}
