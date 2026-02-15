<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Examination>
 */
class ExaminationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $examTypes = ['term', 'midterm', 'final', 'unit', 'quarterly'];
        $startTime = fake()->time('H:i');

        return [
            'name' => fake()->randomElement(['Term', 'Midterm', 'Final', 'Unit', 'Quarterly']).' Examination '.fake()->year(),
            'exam_type' => fake()->randomElement($examTypes),
            'exam_date' => fake()->dateTimeBetween('now', '+3 months'),
            'start_time' => $startTime,
            'end_time' => date('H:i', strtotime($startTime.' +2 hours')),
            'total_marks' => fake()->randomElement([50, 100, 150]),
            'passing_marks' => fake()->randomElement([20, 40, 60]),
            'description' => fake()->optional()->sentence(),
            'is_active' => true,
        ];
    }
}
