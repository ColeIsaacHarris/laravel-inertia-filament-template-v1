<?php

namespace Database\Factories;

use App\Enums\CustomerTier;
use App\Enums\CustomerType;
use App\Enums\PaymentTerms;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
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
            'customer_type' => fake()->randomElement(CustomerType::cases())->value,
            'tier' => fake()->randomElement(CustomerTier::cases())->value,
            'tax_exempt' => false,
            'payment_terms' => fake()->randomElement(PaymentTerms::cases())->value,
            'credit_limit_cents' => fake()->numberBetween(100000, 10000000),
            'is_active' => true,
        ];
    }
}
