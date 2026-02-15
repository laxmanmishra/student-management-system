<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'message' => fake()->paragraph(2),
            'type' => fake()->randomElement(['info', 'warning', 'success', 'danger']),
            'target_audience' => fake()->randomElement(['all', 'students', 'teachers', 'admins']),
            'is_read' => fake()->boolean(30),
            'is_active' => fake()->boolean(80),
            'published_at' => fake()->dateTimeBetween('-1 week', 'now'),
            'expires_at' => fake()->optional(0.5)->dateTimeBetween('+1 week', '+1 month'),
        ];
    }
}
