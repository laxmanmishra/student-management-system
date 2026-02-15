<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class AcademicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subject::query()->delete();
        Section::query()->delete();
        SchoolClass::query()->delete();

        $classes = [
            ['name' => 'Class 1', 'numeric_name' => 'I', 'description' => 'First grade students'],
            ['name' => 'Class 2', 'numeric_name' => 'II', 'description' => 'Second grade students'],
            ['name' => 'Class 3', 'numeric_name' => 'III', 'description' => 'Third grade students'],
            ['name' => 'Class 4', 'numeric_name' => 'IV', 'description' => 'Fourth grade students'],
            ['name' => 'Class 5', 'numeric_name' => 'V', 'description' => 'Fifth grade students'],
            ['name' => 'Class 6', 'numeric_name' => 'VI', 'description' => 'Sixth grade students'],
            ['name' => 'Class 7', 'numeric_name' => 'VII', 'description' => 'Seventh grade students'],
            ['name' => 'Class 8', 'numeric_name' => 'VIII', 'description' => 'Eighth grade students'],
            ['name' => 'Class 9', 'numeric_name' => 'IX', 'description' => 'Ninth grade students'],
            ['name' => 'Class 10', 'numeric_name' => 'X', 'description' => 'Tenth grade students'],
        ];

        $sections = ['A', 'B', 'C'];

        foreach ($classes as $classData) {
            $class = SchoolClass::create([
                'name' => $classData['name'],
                'numeric_name' => $classData['numeric_name'],
                'description' => $classData['description'],
                'is_active' => true,
            ]);

            foreach ($sections as $sectionName) {
                Section::create([
                    'name' => $sectionName,
                    'school_class_id' => $class->id,
                    'capacity' => 40,
                    'is_active' => true,
                ]);
            }
        }

        $subjects = [
            ['name' => 'Mathematics', 'code' => 'MATH01', 'description' => 'Study of numbers and calculations'],
            ['name' => 'English', 'code' => 'ENG01', 'description' => 'English language and literature'],
            ['name' => 'Science', 'code' => 'SCI01', 'description' => 'General science for primary classes'],
            ['name' => 'Social Studies', 'code' => 'SST01', 'description' => 'History, geography and civics'],
            ['name' => 'Hindi', 'code' => 'HIN01', 'description' => 'Hindi language and literature'],
            ['name' => 'Computer Science', 'code' => 'CS01', 'description' => 'Basic computer skills and programming'],
            ['name' => 'Physical Education', 'code' => 'PE01', 'description' => 'Sports and physical fitness'],
            ['name' => 'Art', 'code' => 'ART01', 'description' => 'Drawing and painting'],
            ['name' => 'Music', 'code' => 'MUS01', 'description' => 'Vocal and instrumental music'],
            ['name' => 'Physics', 'code' => 'PHY01', 'description' => 'Study of matter and energy'],
            ['name' => 'Chemistry', 'code' => 'CHE01', 'description' => 'Study of substances and reactions'],
            ['name' => 'Biology', 'code' => 'BIO01', 'description' => 'Study of living organisms'],
        ];

        foreach ($subjects as $subjectData) {
            Subject::create([
                'name' => $subjectData['name'],
                'code' => $subjectData['code'],
                'description' => $subjectData['description'],
                'is_active' => true,
            ]);
        }
    }
}
