<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubjectController extends Controller
{
    public function index(): View
    {
        $subjects = Subject::with('teachers')
            ->latest()
            ->paginate(10);

        return view('admin.subjects.index', [
            'page' => 'Subjects',
            'subjects' => $subjects,
        ]);
    }

    public function create(): View
    {
        $teachers = User::where('role', 'teacher')->get();
        $classes = SchoolClass::where('is_active', true)->get();

        return view('admin.subjects.create', [
            'page' => 'Add Subject',
            'teachers' => $teachers,
            'classes' => $classes,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:subjects'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'teachers' => ['nullable', 'array'],
            'teachers.*' => ['exists:users,id'],
            'classes' => ['nullable', 'array'],
            'classes.*' => ['exists:school_classes,id'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $subject = Subject::create($validated);

        if ($request->has('teachers')) {
            $subject->teachers()->sync($request->input('teachers', []));
        }

        if ($request->has('classes')) {
            $subject->schoolClasses()->sync($request->input('classes', []));
        }

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject created successfully.');
    }

    public function show(Subject $subject): View
    {
        $subject->load(['teachers', 'schoolClasses']);

        return view('admin.subjects.show', [
            'page' => 'Subject Details',
            'subject' => $subject,
        ]);
    }

    public function edit(Subject $subject): View
    {
        $teachers = User::where('role', 'teacher')->get();
        $classes = SchoolClass::where('is_active', true)->get();
        $subject->load(['teachers', 'schoolClasses']);

        return view('admin.subjects.edit', [
            'page' => 'Edit Subject',
            'subject' => $subject,
            'teachers' => $teachers,
            'classes' => $classes,
        ]);
    }

    public function update(Request $request, Subject $subject): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:subjects,code,'.$subject->id],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'teachers' => ['nullable', 'array'],
            'teachers.*' => ['exists:users,id'],
            'classes' => ['nullable', 'array'],
            'classes.*' => ['exists:school_classes,id'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $subject->update($validated);
        $subject->teachers()->sync($request->input('teachers', []));
        $subject->schoolClasses()->sync($request->input('classes', []));

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject): RedirectResponse
    {
        $subject->delete();

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject deleted successfully.');
    }

    public function assignTeachers(Request $request, Subject $subject): RedirectResponse
    {
        $validated = $request->validate([
            'teachers' => ['required', 'array'],
            'teachers.*' => ['exists:users,id'],
        ]);

        $subject->teachers()->sync($validated['teachers']);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Teachers assigned to subject successfully.');
    }
}
