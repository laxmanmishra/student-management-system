<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Notification::query()->delete();

        $admin = User::where('role', 'admin')->first();

        if (! $admin) {
            return;
        }

        $notifications = [
            [
                'title' => 'Welcome to the New Academic Year',
                'message' => 'We are excited to welcome all students and staff to the new academic year. Please check the updated schedule and make sure to attend orientation sessions.',
                'type' => 'info',
                'target_audience' => 'all',
                'is_active' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Exam Schedule Released',
                'message' => 'The mid-term examination schedule has been released. Please check the notice board or log in to your student portal for detailed information.',
                'type' => 'warning',
                'target_audience' => 'students',
                'is_active' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Fee Payment Reminder',
                'message' => 'This is a reminder that the fee payment deadline is approaching. Please ensure timely payment to avoid late fees.',
                'type' => 'danger',
                'target_audience' => 'students',
                'is_active' => true,
                'published_at' => now()->subDay(),
            ],
            [
                'title' => 'Staff Meeting Scheduled',
                'message' => 'A staff meeting has been scheduled for next Monday at 10:00 AM in the conference room. Attendance is mandatory.',
                'type' => 'info',
                'target_audience' => 'teachers',
                'is_active' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'System Maintenance Notice',
                'message' => 'The student portal will undergo scheduled maintenance this weekend. Please save your work before Saturday 10:00 PM.',
                'type' => 'warning',
                'target_audience' => 'all',
                'is_active' => true,
                'published_at' => now(),
                'expires_at' => now()->addWeek(),
            ],
            [
                'title' => 'Sports Day Registration Open',
                'message' => 'Registration for annual sports day is now open. Students interested in participating should register with their class teacher.',
                'type' => 'success',
                'target_audience' => 'students',
                'is_active' => true,
                'published_at' => now()->subHours(6),
            ],
        ];

        foreach ($notifications as $notification) {
            Notification::create(array_merge($notification, [
                'created_by' => $admin->id,
            ]));
        }
    }
}
