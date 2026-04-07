<?php

namespace Database\Factories;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderItem>
 */
class OrderItemFactory extends Factory
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
            'list_price_cents' => fake()->numberBetween(10000, 500000),
            'discount_cents' => 0,
            'net_price_cents' => fake()->numberBetween(10000, 500000),
            'line_total_cents' => fake()->numberBetween(10000, 5000000),
            'sort_order' => fake()->numberBetween(1, 20),
        ];
    }
}
