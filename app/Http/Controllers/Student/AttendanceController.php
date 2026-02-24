<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(Request $request): View
    {
        /** @var User $student */
        $student = auth()->user();

        $query = Attendance::with(['schoolClass', 'section', 'markedBy'])
            ->where('user_id', $student->id);

        if ($request->filled('month')) {
            $query->whereRaw('DATE_FORMAT(date, "%Y-%m") = ?', [$request->month]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendance = $query->latest('date')->paginate(20);

        $stats = Attendance::where('user_id', $student->id)
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_count,
                SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent_count,
                SUM(CASE WHEN status = "late" THEN 1 ELSE 0 END) as late_count,
                SUM(CASE WHEN status = "excused" THEN 1 ELSE 0 END) as excused_count
            ')
            ->first();

        return view('student.attendance.index', [
            'page' => 'My Attendance',
            'attendance' => $attendance,
            'stats' => $stats,
        ]);
    }
}
