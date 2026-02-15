<?php

namespace Database\Seeders;

use App\Models\Fee;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Database\Seeder;

class FeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Fee::query()->delete();

        $students = User::where('role', 'student')->get();
        $classes = SchoolClass::where('is_active', true)->get();
        $admin = User::where('role', 'admin')->first();

        if ($students->isEmpty() || $classes->isEmpty()) {
            return;
        }

        $feeTypes = [
            'tuition' => 15000,
            'admission' => 5000,
            'exam' => 2000,
            'library' => 1000,
            'transport' => 3000,
            'lab' => 1500,
            'sports' => 1000,
        ];

        foreach ($students->take(10) as $student) {
            $class = $classes->random();

            foreach (fake()->randomElements(array_keys($feeTypes), 2) as $feeType) {
                $amount = $feeTypes[$feeType];
                $discount = fake()->randomElement([0, 500, 1000]);
                $paidAmount = fake()->randomElement([0, $amount / 2, $amount - $discount]);
                $status = $paidAmount >= ($amount - $discount) ? 'paid' : ($paidAmount > 0 ? 'partial' : 'pending');

                Fee::create([
                    'user_id' => $student->id,
                    'school_class_id' => $class->id,
                    'fee_type' => $feeType,
                    'amount' => $amount,
                    'paid_amount' => $paidAmount,
                    'discount' => $discount,
                    'status' => $status,
                    'due_date' => fake()->dateTimeBetween('now', '+2 months'),
                    'paid_date' => $paidAmount > 0 ? now() : null,
                    'payment_method' => $paidAmount > 0 ? fake()->randomElement(['cash', 'card', 'bank_transfer', 'online']) : null,
                    'collected_by' => $paidAmount > 0 ? $admin?->id : null,
                    'remarks' => fake()->optional(0.3)->sentence(),
                ]);
            }
        }
    }
}
