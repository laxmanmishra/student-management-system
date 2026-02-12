<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        User::updateOrCreate(
            ['email' => 'student@example.com'],
            [
                'first_name' => 'Student',
                'last_name' => 'One',
                'bio'=>'Student One',
                'phone' => '1234567890',
                'address' => '123 Main St',
                'city' => 'New York',
                'state' => 'New York',
                'zip' => '12345',
                'country' => 'USA',
                'avatar' => '123 Main St',
                'facebook_link' => 'https://www.facebook.com/studentone',
                'x_link' => 'https://www.twitter.com/studentone',
                'instagram_link' => 'https://www.instagram.com/studentone',
                'linkedin_link' => 'https://www.linkedin.com/studentone',
                'name' => 'Student One',
                'password' => Hash::make('123456'),
                'role' => 'student',
            ]
        );
    }
}
