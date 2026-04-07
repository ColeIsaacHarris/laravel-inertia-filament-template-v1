<?php

namespace Database\Factories;

use App\Models\CycleCount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CycleCount>
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
