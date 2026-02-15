<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('123456'),
                'role' => 'student',
            ]
        );

        // $this->call(AdminSeeder::class); //for single

        $this->call([
            AdminSeeder::class,
            TeacherSeeder::class,
            StudentSeeder::class,
            AcademicSeeder::class,
            AttendanceSeeder::class,
            ExaminationSeeder::class,
            FeeSeeder::class,
            NotificationSeeder::class,
        ]);

    }
}
