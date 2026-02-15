<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(Request $request): View
    {
        $query = Attendance::with(['student', 'schoolClass', 'section', 'markedBy']);

        if ($request->filled('class_id')) {
            $query->where('school_class_id', $request->class_id);
        }

        if ($request->filled('section_id')) {
            $query->where('section_id', $request->section_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query->latest('date')->paginate(15);
        $classes = SchoolClass::where('is_active', true)->get();
        $sections = Section::where('is_active', true)->get();

        return view('admin.attendance.index', [
            'page' => 'Attendance',
            'attendances' => $attendances,
            'classes' => $classes,
            'sections' => $sections,
        ]);
    }

    public function create(): View
    {
        $classes = SchoolClass::where('is_active', true)->get();
        $sections = Section::where('is_active', true)->get();

        return view('admin.attendance.create', [
            'page' => 'Mark Attendance',
            'classes' => $classes,
            'sections' => $sections,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'school_class_id' => ['required', 'exists:school_classes,id'],
            'section_id' => ['required', 'exists:sections,id'],
            'date' => ['required', 'date'],
            'attendance' => ['required', 'array'],
            'attendance.*.user_id' => ['required', 'exists:users,id'],
            'attendance.*.status' => ['required', 'in:present,absent,late,excused'],
            'attendance.*.remarks' => ['nullable', 'string'],
        ]);

        foreach ($validated['attendance'] as $record) {
            Attendance::updateOrCreate(
                [
                    'user_id' => $record['user_id'],
                    'date' => $validated['date'],
                ],
                [
                    'school_class_id' => $validated['school_class_id'],
                    'section_id' => $validated['section_id'],
                    'status' => $record['status'],
                    'remarks' => $record['remarks'] ?? null,
                    'marked_by' => auth()->id(),
                ]
            );
        }

        return redirect()->route('admin.attendance.index')
            ->with('success', 'Attendance marked successfully.');
    }

    public function show(Attendance $attendance): View
    {
        $attendance->load(['student', 'schoolClass', 'section', 'markedBy']);

        return view('admin.attendance.show', [
            'page' => 'Attendance Details',
            'attendance' => $attendance,
        ]);
    }

    public function edit(Attendance $attendance): View
    {
        $attendance->load(['student', 'schoolClass', 'section']);

        return view('admin.attendance.edit', [
            'page' => 'Edit Attendance',
            'attendance' => $attendance,
        ]);
    }

    public function update(Request $request, Attendance $attendance): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:present,absent,late,excused'],
            'remarks' => ['nullable', 'string'],
        ]);

        $attendance->update($validated);

        return redirect()->route('admin.attendance.index')
            ->with('success', 'Attendance updated successfully.');
    }

    public function destroy(Attendance $attendance): RedirectResponse
    {
        $attendance->delete();

        return redirect()->route('admin.attendance.index')
            ->with('success', 'Attendance record deleted successfully.');
    }

    public function getStudents(Request $request)
    {
        $request->validate([
            'class_id' => ['required', 'exists:school_classes,id'],
            'section_id' => ['required', 'exists:sections,id'],
            'date' => ['required', 'date'],
        ]);

        $students = User::where('role', 'student')->get();

        $existingAttendance = Attendance::where('school_class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->whereDate('date', $request->date)
            ->pluck('status', 'user_id')
            ->toArray();

        return response()->json([
            'students' => $students,
            'existingAttendance' => $existingAttendance,
        ]);
    }

    public function report(Request $request): View
    {
        $classes = SchoolClass::where('is_active', true)->get();
        $sections = Section::where('is_active', true)->get();
        $report = [];

        if ($request->filled(['class_id', 'section_id', 'month'])) {
            $month = $request->month;
            $students = User::where('role', 'student')->get();

            foreach ($students as $student) {
                $attendances = Attendance::where('user_id', $student->id)
                    ->where('school_class_id', $request->class_id)
                    ->where('section_id', $request->section_id)
                    ->whereMonth('date', date('m', strtotime($month)))
                    ->whereYear('date', date('Y', strtotime($month)))
                    ->get();

                $report[] = [
                    'student' => $student,
                    'present' => $attendances->where('status', 'present')->count(),
                    'absent' => $attendances->where('status', 'absent')->count(),
                    'late' => $attendances->where('status', 'late')->count(),
                    'excused' => $attendances->where('status', 'excused')->count(),
                    'total' => $attendances->count(),
                ];
            }
        }

        return view('admin.attendance.report', [
            'page' => 'Attendance Report',
            'classes' => $classes,
            'sections' => $sections,
            'report' => $report,
        ]);
    }
}
