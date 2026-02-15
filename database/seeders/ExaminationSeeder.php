<?php

namespace Database\Seeders;

use App\Models\Examination;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExaminationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Examination::query()->delete();

        $classes = SchoolClass::where('is_active', true)->get();
        $subjects = Subject::where('is_active', true)->get();
        $admin = User::where('role', 'admin')->first();

        if ($classes->isEmpty() || $subjects->isEmpty()) {
            return;
        }

        $examTypes = ['term', 'midterm', 'final', 'unit', 'quarterly'];
        $examNames = [
            'term' => 'Term Examination',
            'midterm' => 'Midterm Examination',
            'final' => 'Final Examination',
            'unit' => 'Unit Test',
            'quarterly' => 'Quarterly Examination',
        ];

        foreach ($classes as $class) {
            foreach ($subjects->take(3) as $subject) {
                $examType = fake()->randomElement($examTypes);

                Examination::create([
                    'name' => $examNames[$examType].' - '.$subject->name,
                    'exam_type' => $examType,
                    'school_class_id' => $class->id,
                    'subject_id' => $subject->id,
                    'exam_date' => fake()->dateTimeBetween('now', '+2 months'),
                    'start_time' => '09:00',
                    'end_time' => '11:00',
                    'total_marks' => 100,
                    'passing_marks' => 40,
                    'description' => 'Examination for '.$subject->name.' in '.$class->name,
                    'is_active' => true,
                    'created_by' => $admin?->id,
                ]);
            }
        }
    }
}
