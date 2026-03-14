<?php

namespace Database\Factories;

use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount_cents' => fake()->numberBetween(10000, 5000000),
            'payment_method' => fake()->randomElement(PaymentMethod::cases())->value,
            'reference_number' => fake()->bothify('REF-######'),
            'payment_date' => now(),
        ];
    }
}
