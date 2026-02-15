<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Attendance::query()->delete();

        $students = User::where('role', 'student')->get();
        $classes = SchoolClass::where('is_active', true)->get();
        $admin = User::where('role', 'admin')->first();

        if ($students->isEmpty() || $classes->isEmpty()) {
            return;
        }

        $startDate = Carbon::now()->subDays(14);
        $endDate = Carbon::now();

        foreach ($students as $student) {
            $class = $classes->random();
            $section = Section::where('school_class_id', $class->id)->first();

            if (! $section) {
                continue;
            }

            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                if ($date->isWeekend()) {
                    continue;
                }

                Attendance::create([
                    'user_id' => $student->id,
                    'school_class_id' => $class->id,
                    'section_id' => $section->id,
                    'date' => $date->format('Y-m-d'),
                    'status' => fake()->randomElement(['present', 'present', 'present', 'present', 'absent', 'late']),
                    'remarks' => fake()->optional(0.1)->sentence(),
                    'marked_by' => $admin?->id,
                ]);
            }
        }
    }
}
