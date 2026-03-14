<?php

namespace Database\Factories;

use App\Enums\DeliveryWindow;
use App\Models\Customer;
use App\Models\SalesOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeliveryRequest>
 */
class DeliveryRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => SalesOrder::factory(),
            'customer_id' => Customer::factory(),
            'requested_date' => fake()->dateTimeBetween('+3 days', '+30 days'),
            'requested_window' => fake()->randomElement(DeliveryWindow::cases())->value,
            'access_instructions' => fake()->optional()->sentence(),
        ];
    }
}
