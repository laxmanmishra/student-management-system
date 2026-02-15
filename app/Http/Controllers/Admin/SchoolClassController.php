<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SchoolClassController extends Controller
{
    public function index(): View
    {
        $classes = SchoolClass::with(['classTeacher', 'sections'])
            ->latest()
            ->paginate(10);

        return view('admin.classes.index', [
            'page' => 'Classes',
            'classes' => $classes,
        ]);
    }

    public function create(): View
    {
        $teachers = User::where('role', 'teacher')->get();

        return view('admin.classes.create', [
            'page' => 'Add Class',
            'teachers' => $teachers,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'numeric_name' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'class_teacher_id' => ['nullable', 'exists:users,id'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        SchoolClass::create($validated);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Class created successfully.');
    }

    public function show(SchoolClass $class): View
    {
        $class->load(['classTeacher', 'sections', 'subjects']);

        return view('admin.classes.show', [
            'page' => 'Class Details',
            'class' => $class,
        ]);
    }

    public function edit(SchoolClass $class): View
    {
        $teachers = User::where('role', 'teacher')->get();

        return view('admin.classes.edit', [
            'page' => 'Edit Class',
            'class' => $class,
            'teachers' => $teachers,
        ]);
    }

    public function update(Request $request, SchoolClass $class): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'numeric_name' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'class_teacher_id' => ['nullable', 'exists:users,id'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $class->update($validated);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Class updated successfully.');
    }

    public function destroy(SchoolClass $class): RedirectResponse
    {
        $class->delete();

        return redirect()->route('admin.classes.index')
            ->with('success', 'Class deleted successfully.');
    }

    public function assignTeacher(Request $request, SchoolClass $class): RedirectResponse
    {
        $validated = $request->validate([
            'class_teacher_id' => ['required', 'exists:users,id'],
        ]);

        $class->update($validated);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Class teacher assigned successfully.');
    }
}
