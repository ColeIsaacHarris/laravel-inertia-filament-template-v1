<?php

namespace Database\Factories;

use App\Enums\PaymentTerms;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_name' => fake()->company(),
            'trade_name' => fake()->company(),
            'country' => fake()->countryCode(),
            'default_payment_terms' => fake()->randomElement(PaymentTerms::cases())->value,
            'default_currency' => 'USD',
            'is_active' => true,
        ];
    }
}
