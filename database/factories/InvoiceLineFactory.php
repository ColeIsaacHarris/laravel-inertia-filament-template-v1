<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvoiceLine>
 */
class InvoiceLineFactory extends Factory
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
            'amount_cents' => fake()->numberBetween(10000, 5000000),
            'tax_cents' => fake()->numberBetween(500, 50000),
        ];
    }
}
