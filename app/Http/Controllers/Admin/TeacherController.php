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

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $teachers = User::where('role', 'teacher')
            ->latest()
            ->paginate(10);

        return view('admin.teachers.index', [
            'page' => 'Teachers',
            'teachers' => $teachers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.teachers.create', [
            'page' => 'Add Teacher',
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
        $data['role'] = 'teacher';

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        User::create($data);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $teacher): View
    {
        return view('admin.teachers.show', [
            'page' => 'Teacher Details',
            'teacher' => $teacher,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $teacher): View
    {
        return view('admin.teachers.edit', [
            'page' => 'Edit Teacher',
            'teacher' => $teacher,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $teacher): RedirectResponse
    {
        $data = $request->validated();
        $data['name'] = $data['first_name'].' '.$data['last_name'];

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('avatar')) {
            if ($teacher->avatar) {
                Storage::disk('public')->delete($teacher->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $teacher->update($data);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $teacher): RedirectResponse
    {
        if ($teacher->avatar) {
            Storage::disk('public')->delete($teacher->avatar);
        }

        $teacher->delete();

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher deleted successfully.');
    }

    /**
     * Reset password for the specified teacher.
     */
    public function resetPassword(User $teacher): RedirectResponse
    {
        $newPassword = 'password123';
        $teacher->update(['password' => Hash::make($newPassword)]);

        return redirect()->route('admin.teachers.index')
            ->with('success', "Password reset to: {$newPassword}");
    }
}
