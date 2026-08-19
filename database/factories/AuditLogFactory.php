<?php

namespace Database\Factories;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AuditLog>
 */
class AuditLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'action' => fake()->randomElement(['create', 'update', 'delete']),
            'entity_type' => fake()->randomElement(['App\\Models\\User', 'App\\Models\\Role']),
            'entity_id' => fake()->uuid(),
            'old_values' => [],
            'new_values' => ['field' => 'value'],
            'ip_address' => fake()->ipv4(),
        ];
    }
}
