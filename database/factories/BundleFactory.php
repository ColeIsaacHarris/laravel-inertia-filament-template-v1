<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bundle>
 */
class BundleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bundle_number' => fake()->unique()->bothify('BDL-####'),
            'expected_slab_count' => fake()->numberBetween(4, 12),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
