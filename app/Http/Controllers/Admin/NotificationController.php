<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Notification::with(['createdBy', 'targetUser', 'schoolClass']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('target_audience')) {
            $query->where('target_audience', $request->target_audience);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $notifications = $query->latest()->paginate(15);

        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $classes = SchoolClass::where('is_active', true)->get();
        $users = User::all();

        return view('admin.notifications.create', compact('classes', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'type' => ['required', 'in:info,warning,success,danger'],
            'target_audience' => ['required', 'in:all,students,teachers,admins,specific'],
            'target_user_id' => ['nullable', 'exists:users,id'],
            'school_class_id' => ['nullable', 'exists:school_classes,id'],
            'is_active' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date', 'after:published_at'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['created_by'] = auth()->id();
        $validated['published_at'] = $validated['published_at'] ?? now();

        Notification::create($validated);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification): View
    {
        $notification->load(['createdBy', 'targetUser', 'schoolClass']);

        return view('admin.notifications.show', compact('notification'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification): View
    {
        $classes = SchoolClass::where('is_active', true)->get();
        $users = User::all();

        return view('admin.notifications.edit', compact('notification', 'classes', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'type' => ['required', 'in:info,warning,success,danger'],
            'target_audience' => ['required', 'in:all,students,teachers,admins,specific'],
            'target_user_id' => ['nullable', 'exists:users,id'],
            'school_class_id' => ['nullable', 'exists:school_classes,id'],
            'is_active' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date', 'after:published_at'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $notification->update($validated);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification): RedirectResponse
    {
        $notification->delete();

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification deleted successfully.');
    }
}
