<?php

namespace Database\Factories;

use App\Enums\MediaType;
use App\Models\SlabMedia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SlabMedia>
 */
class SlabMediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'media_type' => fake()->randomElement(MediaType::cases())->value,
            'file_path' => 'slabs/'.fake()->uuid().'.jpg',
            'original_filename' => fake()->word().'.jpg',
            'mime_type' => 'image/jpeg',
            'file_size_bytes' => fake()->numberBetween(100000, 5000000),
            'is_primary' => false,
            'sort_order' => fake()->numberBetween(1, 10),
        ];
    }
}
