<?php

namespace Database\Factories;

use App\Enums\PortalRole;
use App\Models\PortalUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PortalUser>
 */
class PortalUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'password_hash' => bcrypt('password'),
            'role' => fake()->randomElement(PortalRole::cases())->value,
            'two_factor_enabled' => false,
            'permissions' => [],
            'is_active' => true,
        ];
    }
}
