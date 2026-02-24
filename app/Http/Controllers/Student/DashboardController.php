<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Examination;
use App\Models\Fee;
use App\Models\Notification;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        /** @var User $student */
        $student = auth()->user();

        $studentClassId = Attendance::where('user_id', $student->id)
            ->latest('date')
            ->value('school_class_id');

        $currentMonth = now()->startOfMonth();

        $monthlyAttendance = Attendance::where('user_id', $student->id)
            ->whereBetween('date', [$currentMonth, now()])
            ->get();

        $totalDays = $monthlyAttendance->count();
        $presentDays = $monthlyAttendance->where('status', 'present')->count();
        $absentDays = $monthlyAttendance->where('status', 'absent')->count();
        $lateDays = $monthlyAttendance->where('status', 'late')->count();
        $attendanceRate = $totalDays > 0 ? round(($presentDays / $totalDays) * 100, 1) : 0;

        $myFees = Fee::where('user_id', $student->id)->get();
        $totalFeeAmount = $myFees->sum('amount');
        $totalPaidAmount = $myFees->sum('paid_amount');
        $totalBalance = $myFees->sum(fn ($f) => $f->amount - $f->discount - $f->paid_amount);
        $pendingFeesCount = $myFees->whereIn('status', ['pending', 'partial', 'overdue'])->count();

        $upcomingExams = Examination::where('exam_date', '>=', today())
            ->where('is_active', true)
            ->when($studentClassId, fn ($q) => $q->where('school_class_id', $studentClassId))
            ->with(['subject', 'schoolClass'])
            ->orderBy('exam_date')
            ->limit(5)
            ->get();

        $recentNotifications = Notification::where('is_active', true)
            ->where(function ($q) use ($student) {
                $q->whereIn('target_audience', ['all', 'students'])
                    ->orWhere('target_user_id', $student->id);
            })
            ->latest()
            ->limit(5)
            ->get();

        $recentAttendance = Attendance::with(['schoolClass', 'section', 'markedBy'])
            ->where('user_id', $student->id)
            ->latest('date')
            ->limit(8)
            ->get();

        $overdueFeesCount = $myFees->where('status', 'overdue')->count();

        return view('student.dashboard', [
            'page' => 'Student Dashboard',
            'student' => $student,
            'totalDays' => $totalDays,
            'presentDays' => $presentDays,
            'absentDays' => $absentDays,
            'lateDays' => $lateDays,
            'attendanceRate' => $attendanceRate,
            'totalFeeAmount' => $totalFeeAmount,
            'totalPaidAmount' => $totalPaidAmount,
            'totalBalance' => $totalBalance,
            'pendingFeesCount' => $pendingFeesCount,
            'overdueFeesCount' => $overdueFeesCount,
            'upcomingExams' => $upcomingExams,
            'recentNotifications' => $recentNotifications,
            'recentAttendance' => $recentAttendance,
        ]);
    }
}
