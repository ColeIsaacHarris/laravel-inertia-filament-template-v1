<?php

namespace Database\Factories;

use App\Enums\QualityGrade;
use App\Enums\SlabFinish;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slab>
 */
class SlabFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'finish' => fake()->randomElement(SlabFinish::cases())->value,
            'quality_grade' => fake()->randomElement(QualityGrade::cases())->value,
        ];
    }
}
