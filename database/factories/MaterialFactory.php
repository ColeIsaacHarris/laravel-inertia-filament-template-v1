<?php

namespace Database\Factories;

use App\Enums\ColorFamily;
use App\Enums\MaterialType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Material>
 */
class MaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'material_name' => fake()->word(),
            'material_type' => fake()->randomElement(MaterialType::cases())->value,
            'color_family' => fake()->randomElement(ColorFamily::cases())->value,
        ];
    }
}
