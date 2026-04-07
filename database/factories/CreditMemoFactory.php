<?php

namespace Database\Factories;

use App\Models\CreditMemo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CreditMemo>
 */
class CreditMemoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'credit_memo_number' => fake()->unique()->bothify('CM-####'),
            'amount_cents' => fake()->numberBetween(10000, 500000),
            'reason' => fake()->sentence(),
        ];
    }
}
