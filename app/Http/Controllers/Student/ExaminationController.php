<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Examination;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExaminationController extends Controller
{
    public function index(Request $request): View
    {
        /** @var User $student */
        $student = auth()->user();

        $studentClassId = Attendance::where('user_id', $student->id)
            ->latest('date')
            ->value('school_class_id');

        $query = Examination::with(['schoolClass', 'subject', 'createdBy'])
            ->where('is_active', true)
            ->when($studentClassId, fn ($q) => $q->where('school_class_id', $studentClassId));

        if ($request->filled('exam_type')) {
            $query->where('exam_type', $request->exam_type);
        }

        if ($request->filled('filter') && $request->filter === 'upcoming') {
            $query->where('exam_date', '>=', today());
        } elseif ($request->filled('filter') && $request->filter === 'past') {
            $query->where('exam_date', '<', today());
        }

        $examinations = $query->orderBy('exam_date', 'desc')->paginate(15);

        return view('student.examinations.index', [
            'page' => 'My Examinations',
            'examinations' => $examinations,
            'studentClassId' => $studentClassId,
        ]);
    }

    public function show(Examination $examination): View
    {
        $examination->load(['schoolClass', 'subject', 'createdBy']);

        return view('student.examinations.show', [
            'page' => 'Examination Details',
            'examination' => $examination,
        ]);
    }
}
