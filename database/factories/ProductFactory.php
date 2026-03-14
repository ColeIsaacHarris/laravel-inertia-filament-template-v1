<?php

namespace Database\Factories;

use App\Enums\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sku' => fake()->unique()->bothify('???-####'),
            'name' => fake()->words(3, true),
            'category' => fake()->randomElement(ProductCategory::cases())->value,
            'unit_of_measure' => 'each',
            'quantity_on_hand' => fake()->numberBetween(0, 100),
            'cost_cents' => fake()->numberBetween(1000, 50000),
            'list_price_cents' => fake()->numberBetween(2000, 100000),
            'is_active' => true,
        ];
    }
}
