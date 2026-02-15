<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fee>
 */
class FeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $feeTypes = ['tuition', 'admission', 'exam', 'library', 'transport', 'lab', 'sports', 'other'];
        $amount = fake()->randomElement([5000, 10000, 15000, 20000, 25000]);
        $paidAmount = fake()->randomElement([0, $amount / 2, $amount]);
        $status = $paidAmount >= $amount ? 'paid' : ($paidAmount > 0 ? 'partial' : 'pending');

        return [
            'fee_type' => fake()->randomElement($feeTypes),
            'amount' => $amount,
            'paid_amount' => $paidAmount,
            'discount' => fake()->randomElement([0, 500, 1000]),
            'status' => $status,
            'due_date' => fake()->dateTimeBetween('now', '+3 months'),
            'paid_date' => $paidAmount > 0 ? fake()->dateTimeBetween('-1 month', 'now') : null,
            'payment_method' => $paidAmount > 0 ? fake()->randomElement(['cash', 'card', 'bank_transfer', 'online']) : null,
            'remarks' => fake()->optional()->sentence(),
        ];
    }
}
