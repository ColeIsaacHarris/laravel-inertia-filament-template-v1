<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CycleCount>
 */
class CycleCountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'count_type' => fake()->randomElement(['full', 'partial', 'spot']),
            'status' => fake()->randomElement(['planned', 'in_progress', 'completed']),
        ];
    }
}
