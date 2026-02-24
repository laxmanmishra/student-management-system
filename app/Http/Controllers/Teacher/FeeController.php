<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeeController extends Controller
{
    public function index(Request $request): View
    {
        $teacher = auth()->user();

        $myClassIds = SchoolClass::where('class_teacher_id', $teacher->id)
            ->pluck('id');

        $query = Fee::with(['student', 'schoolClass'])
            ->whereIn('school_class_id', $myClassIds);

        if ($request->filled('class_id')) {
            $query->where('school_class_id', $request->class_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('fee_type')) {
            $query->where('fee_type', $request->fee_type);
        }

        if ($request->filled('student_id')) {
            $query->where('user_id', $request->student_id);
        }

        $fees = $query->latest()->paginate(15);
        $classes = SchoolClass::whereIn('id', $myClassIds)->get();
        $students = User::where('role', 'student')->get(['id', 'name', 'first_name', 'last_name']);

        return view('teacher.fees.index', [
            'page' => 'Fee Records',
            'fees' => $fees,
            'classes' => $classes,
            'students' => $students,
        ]);
    }

    public function show(Fee $fee): View
    {
        $fee->load(['student', 'schoolClass', 'collectedBy']);

        return view('teacher.fees.show', [
            'page' => 'Fee Details',
            'fee' => $fee,
        ]);
    }
}
