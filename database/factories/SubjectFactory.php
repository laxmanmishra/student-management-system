<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(['Mathematics', 'English', 'Science', 'Social Studies', 'Hindi', 'Computer Science', 'Physical Education', 'Art', 'Music', 'Geography', 'History', 'Biology', 'Physics', 'Chemistry']),
            'code' => fn () => strtoupper(fake()->unique()->lexify('???')).fake()->numerify('##'),
            'description' => fake()->optional()->sentence(),
            'is_active' => true,
        ];
    }
}
