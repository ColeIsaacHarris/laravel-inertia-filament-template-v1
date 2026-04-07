<?php

namespace Database\Factories;

use App\Enums\PortalInvitationStatus;
use App\Enums\PortalRole;
use App\Models\PortalInvitation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PortalInvitation>
 */
class PortalInvitationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->safeEmail(),
            'role' => fake()->randomElement(PortalRole::cases())->value,
            'status' => fake()->randomElement(PortalInvitationStatus::cases())->value,
            'token' => fake()->unique()->uuid(),
            'expires_at' => fake()->dateTimeBetween('+1 day', '+30 days'),
        ];
    }
}
