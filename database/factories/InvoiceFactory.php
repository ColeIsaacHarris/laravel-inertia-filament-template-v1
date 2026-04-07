<?php

namespace Database\Factories;

use App\Enums\PaymentTerms;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_number' => fake()->unique()->bothify('INV-####'),
            'customer_id' => Customer::factory(),
            'invoice_date' => now(),
            'due_date' => fake()->dateTimeBetween('+15 days', '+60 days'),
            'payment_terms' => fake()->randomElement(PaymentTerms::cases())->value,
            'subtotal_cents' => fake()->numberBetween(100000, 5000000),
            'tax_cents' => fake()->numberBetween(5000, 500000),
            'total_cents' => fake()->numberBetween(105000, 5500000),
        ];
    }
}
