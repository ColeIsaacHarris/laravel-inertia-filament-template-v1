<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PortalNotification>
 */
class PortalNotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'notification_type' => fake()->randomElement(['hold_expiring', 'order_update', 'new_message', 'delivery_scheduled']),
            'title' => fake()->sentence(),
            'body' => fake()->paragraph(),
            'is_read' => false,
            'email_sent' => false,
        ];
    }
}
