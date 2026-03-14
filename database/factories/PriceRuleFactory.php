<?php

namespace Database\Factories;

use App\Enums\PricingModel;
use App\Enums\PricingScope;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PriceRule>
 */
class PriceRuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'scope' => fake()->randomElement(PricingScope::cases())->value,
            'priority' => fake()->numberBetween(1, 100),
            'pricing_model' => fake()->randomElement(PricingModel::cases())->value,
            'price_cents' => fake()->numberBetween(1000, 100000),
            'min_quantity' => 1,
            'effective_from' => now(),
            'effective_to' => fake()->dateTimeBetween('+30 days', '+1 year'),
            'is_active' => true,
        ];
    }
}
