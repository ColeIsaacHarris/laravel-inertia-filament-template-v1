<?php

namespace Database\Factories;

use App\Enums\HoldType;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HoldRequest>
 */
class HoldRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'project_name' => fake()->words(3, true),
            'notes' => fake()->optional()->paragraph(),
            'requested_hold_type' => fake()->randomElement(HoldType::cases())->value,
        ];
    }
}
