<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SupplierInvoice>
 */
class SupplierInvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_number' => fake()->unique()->bothify('SI-####'),
            'invoice_date' => now(),
            'due_date' => fake()->dateTimeBetween('+15 days', '+60 days'),
            'amount_cents' => fake()->numberBetween(100000, 5000000),
            'currency' => 'USD',
            'status' => fake()->randomElement(['pending', 'approved', 'paid']),
        ];
    }
}
