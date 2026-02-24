<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Examination;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExaminationController extends Controller
{
    public function index(Request $request): View
    {
        $teacher = auth()->user();

        $myClassIds = SchoolClass::where('class_teacher_id', $teacher->id)
            ->pluck('id');

        $mySubjectIds = Subject::whereHas('teachers', fn ($q) => $q->where('users.id', $teacher->id))
            ->pluck('id');

        $query = Examination::with(['schoolClass', 'subject', 'createdBy'])
            ->where(function ($q) use ($myClassIds, $mySubjectIds) {
                $q->whereIn('school_class_id', $myClassIds)
                    ->orWhereIn('subject_id', $mySubjectIds);
            });

        if ($request->filled('class_id')) {
            $query->where('school_class_id', $request->class_id);
        }

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->filled('exam_type')) {
            $query->where('exam_type', $request->exam_type);
        }

        $examinations = $query->latest()->paginate(15);

        $classes = SchoolClass::whereIn('id', $myClassIds)->get();
        $subjects = Subject::whereIn('id', $mySubjectIds)->get();

        return view('teacher.examinations.index', [
            'page' => 'Examinations',
            'examinations' => $examinations,
            'classes' => $classes,
            'subjects' => $subjects,
        ]);
    }

    public function create(): View
    {
        $teacher = auth()->user();

        $classes = SchoolClass::where(function ($q) use ($teacher) {
            $q->where('class_teacher_id', $teacher->id)
                ->orWhereHas('subjects', fn ($sq) => $sq->whereHas('teachers', fn ($tq) => $tq->where('users.id', $teacher->id)));
        })->where('is_active', true)->get();

        $subjects = Subject::whereHas('teachers', fn ($q) => $q->where('users.id', $teacher->id))
            ->where('is_active', true)
            ->get();

        return view('teacher.examinations.create', [
            'page' => 'Schedule Examination',
            'classes' => $classes,
            'subjects' => $subjects,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'exam_type' => ['required', 'in:term,midterm,final,unit,quarterly'],
            'school_class_id' => ['required', 'exists:school_classes,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'exam_date' => ['required', 'date'],
            'start_time' => ['required'],
            'end_time' => ['required', 'after:start_time'],
            'total_marks' => ['required', 'integer', 'min:1'],
            'passing_marks' => ['required', 'integer', 'min:0', 'lte:total_marks'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $validated['created_by'] = auth()->id();
        $validated['is_active'] = $request->boolean('is_active');

        Examination::create($validated);

        return redirect()->route('teacher.examinations.index')
            ->with('success', 'Examination scheduled successfully.');
    }

    public function show(Examination $examination): View
    {
        $examination->load(['schoolClass', 'subject', 'createdBy']);

        return view('teacher.examinations.show', [
            'page' => 'Examination Details',
            'examination' => $examination,
        ]);
    }

    public function edit(Examination $examination): View
    {
        $teacher = auth()->user();

        $classes = SchoolClass::where(function ($q) use ($teacher) {
            $q->where('class_teacher_id', $teacher->id)
                ->orWhereHas('subjects', fn ($sq) => $sq->whereHas('teachers', fn ($tq) => $tq->where('users.id', $teacher->id)));
        })->where('is_active', true)->get();

        $subjects = Subject::whereHas('teachers', fn ($q) => $q->where('users.id', $teacher->id))
            ->where('is_active', true)
            ->get();

        return view('teacher.examinations.edit', [
            'page' => 'Edit Examination',
            'examination' => $examination,
            'classes' => $classes,
            'subjects' => $subjects,
        ]);
    }

    public function update(Request $request, Examination $examination): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'exam_type' => ['required', 'in:term,midterm,final,unit,quarterly'],
            'school_class_id' => ['required', 'exists:school_classes,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'exam_date' => ['required', 'date'],
            'start_time' => ['required'],
            'end_time' => ['required', 'after:start_time'],
            'total_marks' => ['required', 'integer', 'min:1'],
            'passing_marks' => ['required', 'integer', 'min:0', 'lte:total_marks'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $examination->update($validated);

        return redirect()->route('teacher.examinations.index')
            ->with('success', 'Examination updated successfully.');
    }

    public function destroy(Examination $examination): RedirectResponse
    {
        $examination->delete();

        return redirect()->route('teacher.examinations.index')
            ->with('success', 'Examination deleted successfully.');
    }
}
