<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CycleCountItem>
 */
class CycleCountItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'expected_bin' => fake()->bothify('A-##'),
            'actual_bin' => fake()->bothify('A-##'),
            'is_discrepancy' => false,
        ];
    }
}
