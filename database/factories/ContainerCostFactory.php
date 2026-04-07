<?php

namespace Database\Factories;

use App\Enums\CostAllocationMethod;
use App\Models\ContainerCost;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContainerCost>
 */
class ContainerCostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cost_type' => fake()->randomElement(['freight', 'duty', 'insurance', 'handling', 'storage']),
            'amount_cents' => fake()->numberBetween(10000, 500000),
            'allocation_method' => fake()->randomElement(CostAllocationMethod::cases())->value,
        ];
    }
}
