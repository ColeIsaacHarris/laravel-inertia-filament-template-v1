<?php

namespace Database\Factories;

use App\Enums\QualityGrade;
use App\Enums\SlabFinish;
use App\Models\Slab;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Slab>
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
