<?php

namespace Database\Factories;

use App\Enums\MessageAttachmentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MessageAttachment>
 */
class MessageAttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'attachment_type' => fake()->randomElement(MessageAttachmentType::cases())->value,
            'file_path' => 'attachments/'.fake()->uuid().'.pdf',
            'original_filename' => fake()->word().'.pdf',
            'mime_type' => 'application/pdf',
            'file_size_bytes' => fake()->numberBetween(10000, 5000000),
        ];
    }
}
