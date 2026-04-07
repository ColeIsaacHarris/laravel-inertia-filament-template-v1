<?php

namespace Database\Factories;

use App\Enums\MovementType;
use App\Models\InventoryMovement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InventoryMovement>
 */
class InventoryMovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'movement_type' => fake()->randomElement(MovementType::cases())->value,
            'from_bin' => fake()->optional()->bothify('A-##'),
            'to_bin' => fake()->bothify('B-##'),
        ];
    }
}
