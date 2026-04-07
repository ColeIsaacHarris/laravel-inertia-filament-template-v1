<?php

namespace Database\Factories;

use App\Models\CycleCountItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CycleCountItem>
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
