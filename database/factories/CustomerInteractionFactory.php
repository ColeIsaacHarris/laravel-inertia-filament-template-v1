<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerInteraction>
 */
class CustomerInteractionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'interaction_type' => fake()->randomElement(['call', 'email', 'meeting', 'visit']),
            'subject' => fake()->sentence(),
            'notes' => fake()->paragraph(),
            'follow_up_date' => fake()->optional()->dateTimeBetween('now', '+30 days'),
        ];
    }
}
