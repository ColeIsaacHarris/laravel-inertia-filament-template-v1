<?php

namespace Database\Factories;

use App\Enums\PaymentTerms;
use App\Models\Customer;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Quote>
 */
class QuoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quote_number' => fake()->unique()->bothify('QT-####'),
            'customer_id' => Customer::factory(),
            'sales_rep_id' => User::factory(),
            'expiry_date' => fake()->dateTimeBetween('+7 days', '+60 days'),
            'subtotal_cents' => fake()->numberBetween(100000, 5000000),
            'tax_cents' => fake()->numberBetween(5000, 500000),
            'total_cents' => fake()->numberBetween(105000, 5500000),
            'payment_terms' => fake()->randomElement(PaymentTerms::cases())->value,
        ];
    }
}
