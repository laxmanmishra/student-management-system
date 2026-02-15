<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $students = User::where('role', 'student')
            ->latest()
            ->paginate(10);

        return view('admin.students.index', [
            'page' => 'Students',
            'students' => $students,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.students.create', [
            'page' => 'Add Student',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['name'] = $data['first_name'].' '.$data['last_name'];
        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'student';

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        User::create($data);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $student): View
    {
        return view('admin.students.show', [
            'page' => 'Student Details',
            'student' => $student,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $student): View
    {
        return view('admin.students.edit', [
            'page' => 'Edit Student',
            'student' => $student,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $student): RedirectResponse
    {
        $data = $request->validated();
        $data['name'] = $data['first_name'].' '.$data['last_name'];

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('avatar')) {
            if ($student->avatar) {
                Storage::disk('public')->delete($student->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $student->update($data);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $student): RedirectResponse
    {
        if ($student->avatar) {
            Storage::disk('public')->delete($student->avatar);
        }

        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Student deleted successfully.');
    }

    /**
     * Reset password for the specified student.
     */
    public function resetPassword(User $student): RedirectResponse
    {
        $newPassword = 'password123';
        $student->update(['password' => Hash::make($newPassword)]);

        return redirect()->route('admin.students.index')
            ->with('success', "Password reset to: {$newPassword}");
    }

    /**
     * Change the role of the specified user.
     */
    public function changeRole(UpdateUserRequest $request, User $student): RedirectResponse
    {
        $student->update(['role' => $request->validated()['role']]);

        return redirect()->route('admin.students.index')
            ->with('success', 'User role updated successfully.');
    }
}
