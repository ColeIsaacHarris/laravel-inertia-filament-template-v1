<?php

namespace Database\Factories;

use App\Enums\ContactRole;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'role' => fake()->randomElement(ContactRole::cases())->value,
            'communication_preference' => fake()->randomElement(['email', 'phone', 'text']),
            'is_portal_eligible' => true,
        ];
    }
}
