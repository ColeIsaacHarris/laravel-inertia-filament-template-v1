<?php

namespace Database\Factories;

use App\Enums\DepositStatus;
use App\Enums\HoldType;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hold>
 */
class HoldFactory extends Factory
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
            'hold_type' => fake()->randomElement(HoldType::cases())->value,
            'expiry_date' => fake()->dateTimeBetween('+1 day', '+30 days'),
            'deposit_amount_cents' => fake()->numberBetween(0, 100000),
            'deposit_status' => fake()->randomElement(DepositStatus::cases())->value,
            'reminder_sent' => false,
        ];
    }
}
