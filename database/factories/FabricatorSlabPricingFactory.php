<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FabricatorSlabPricing>
 */
class FabricatorSlabPricingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'markup_percentage' => fake()->randomFloat(2, 5, 50),
            'retail_price_cents' => fake()->numberBetween(50000, 1000000),
        ];
    }
}
