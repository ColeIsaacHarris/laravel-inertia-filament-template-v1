<?php

namespace Database\Factories;

use App\Enums\ContainerSize;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Container>
 */
class ContainerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => fake()->unique()->bothify('CONT-########'),
            'container_size' => fake()->randomElement(ContainerSize::cases())->value,
            'seal_number' => fake()->bothify('SEAL-######'),
            'vessel_name' => fake()->company().' Vessel',
            'port_of_loading' => fake()->city(),
            'port_of_discharge' => fake()->city(),
            'etd' => fake()->dateTimeBetween('-30 days', '+30 days'),
            'eta' => fake()->dateTimeBetween('+30 days', '+90 days'),
        ];
    }
}
