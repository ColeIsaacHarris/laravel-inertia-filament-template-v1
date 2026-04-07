<?php

namespace Database\Factories;

use App\Enums\PaymentTerms;
use App\Models\Customer;
use App\Models\SalesOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SalesOrder>
 */
class SalesOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_number' => fake()->unique()->bothify('SO-####'),
            'customer_id' => Customer::factory(),
            'payment_terms' => fake()->randomElement(PaymentTerms::cases())->value,
            'subtotal_cents' => fake()->numberBetween(100000, 5000000),
            'total_cents' => fake()->numberBetween(100000, 5000000),
            'requested_delivery_date' => fake()->dateTimeBetween('+7 days', '+60 days'),
        ];
    }
}
