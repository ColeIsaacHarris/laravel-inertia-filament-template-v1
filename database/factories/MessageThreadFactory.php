<?php

namespace Database\Factories;

use App\Enums\ThreadType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MessageThread>
 */
class MessageThreadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'thread_type' => fake()->randomElement(ThreadType::cases())->value,
            'subject' => fake()->sentence(),
            'is_closed' => false,
        ];
    }
}
