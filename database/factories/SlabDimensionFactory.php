<?php

namespace Database\Factories;

use App\Enums\DimensionStage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SlabDimension>
 */
class SlabDimensionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'stage' => fake()->randomElement(DimensionStage::cases())->value,
            'length_mm' => fake()->numberBetween(2000, 3500),
            'width_mm' => fake()->numberBetween(1000, 2000),
            'thickness_mm' => fake()->randomElement([20, 30]),
            'measured_at' => now(),
        ];
    }
}
