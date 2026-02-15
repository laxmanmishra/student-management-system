<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Examination;
use App\Models\Fee;
use App\Models\Notification;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Subject;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $totalStudents = User::where('role', 'student')->count();
        $totalTeachers = User::where('role', 'teacher')->count();
        $totalClasses = SchoolClass::count();
        $totalSections = Section::count();
        $totalSubjects = Subject::count();

        $todayAttendance = Attendance::whereDate('date', today())->count();
        $presentToday = Attendance::whereDate('date', today())->where('status', 'present')->count();
        $attendanceRate = $todayAttendance > 0 ? round(($presentToday / $todayAttendance) * 100, 1) : 0;

        $pendingFees = Fee::where('status', 'pending')->sum('amount');
        $collectedFees = Fee::where('status', 'paid')->sum('paid_amount');

        $upcomingExams = Examination::where('exam_date', '>=', today())
            ->orderBy('exam_date')
            ->limit(5)
            ->get();

        $recentNotifications = Notification::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentStudents = User::where('role', 'student')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentFees = Fee::with('student')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'page' => 'Admin Dashboard',
            'totalStudents' => $totalStudents,
            'totalTeachers' => $totalTeachers,
            'totalClasses' => $totalClasses,
            'totalSections' => $totalSections,
            'totalSubjects' => $totalSubjects,
            'attendanceRate' => $attendanceRate,
            'presentToday' => $presentToday,
            'todayAttendance' => $todayAttendance,
            'pendingFees' => $pendingFees,
            'collectedFees' => $collectedFees,
            'upcomingExams' => $upcomingExams,
            'recentNotifications' => $recentNotifications,
            'recentStudents' => $recentStudents,
            'recentFees' => $recentFees,
        ]);
    }
}
