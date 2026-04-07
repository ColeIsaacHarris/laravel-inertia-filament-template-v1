<?php

namespace Database\Factories;

use App\Models\PortalNotification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PortalNotification>
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
