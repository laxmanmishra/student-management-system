<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Examination;
use App\Models\Notification;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        /** @var User $teacher */
        $teacher = auth()->user();

        $myClasses = SchoolClass::where('class_teacher_id', $teacher->id)
            ->where('is_active', true)
            ->withCount('sections')
            ->get();

        $mySubjects = Subject::whereHas('teachers', fn ($q) => $q->where('users.id', $teacher->id))
            ->where('is_active', true)
            ->with(['schoolClasses' => fn ($q) => $q->where('is_active', true)])
            ->get();

        $todayMarkedCount = Attendance::where('marked_by', $teacher->id)
            ->whereDate('date', today())
            ->count();

        $todayPresentCount = Attendance::where('marked_by', $teacher->id)
            ->whereDate('date', today())
            ->where('status', 'present')
            ->count();

        $todayAttendanceRate = $todayMarkedCount > 0
            ? round(($todayPresentCount / $todayMarkedCount) * 100, 1)
            : 0;

        $totalStudents = User::where('role', 'student')->count();

        $myClassIds = $myClasses->pluck('id');
        $mySubjectIds = $mySubjects->pluck('id');

        $upcomingExams = Examination::where('exam_date', '>=', today())
            ->where(function ($q) use ($myClassIds, $mySubjectIds) {
                $q->whereIn('school_class_id', $myClassIds)
                    ->orWhereIn('subject_id', $mySubjectIds);
            })
            ->with(['subject', 'schoolClass'])
            ->orderBy('exam_date')
            ->limit(5)
            ->get();

        $recentNotifications = Notification::where('is_active', true)
            ->where(function ($q) use ($teacher) {
                $q->whereIn('target_audience', ['all', 'teachers'])
                    ->orWhere('target_user_id', $teacher->id);
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentAttendance = Attendance::with(['student', 'schoolClass', 'section'])
            ->where('marked_by', $teacher->id)
            ->latest('date')
            ->limit(8)
            ->get();

        return view('teacher.dashboard', [
            'page' => 'Teacher Dashboard',
            'teacher' => $teacher,
            'myClasses' => $myClasses,
            'mySubjects' => $mySubjects,
            'todayMarkedCount' => $todayMarkedCount,
            'todayPresentCount' => $todayPresentCount,
            'todayAttendanceRate' => $todayAttendanceRate,
            'totalStudents' => $totalStudents,
            'upcomingExams' => $upcomingExams,
            'recentNotifications' => $recentNotifications,
            'recentAttendance' => $recentAttendance,
        ]);
    }
}
