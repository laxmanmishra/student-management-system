<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $teacher = auth()->user();

        $query = Notification::with(['createdBy', 'targetUser', 'schoolClass'])
            ->where('is_active', true)
            ->where(function ($q) use ($teacher) {
                $q->whereIn('target_audience', ['all', 'teachers'])
                    ->orWhere('target_user_id', $teacher->id);
            });

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $notifications = $query->latest()->paginate(15);

        return view('teacher.notifications.index', [
            'page' => 'Notifications',
            'notifications' => $notifications,
        ]);
    }

    public function show(Notification $notification): View
    {
        $notification->load(['createdBy', 'targetUser', 'schoolClass']);

        return view('teacher.notifications.show', [
            'page' => 'Notification Details',
            'notification' => $notification,
        ]);
    }

    public function create(): View
    {
        $teacher = auth()->user();

        $myClassIds = SchoolClass::where('class_teacher_id', $teacher->id)
            ->pluck('id');

        $classes = SchoolClass::whereIn('id', $myClassIds)->where('is_active', true)->get();
        $students = User::where('role', 'student')->get(['id', 'name', 'first_name', 'last_name']);

        return view('teacher.notifications.create', [
            'page' => 'Send Notification',
            'classes' => $classes,
            'students' => $students,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'type' => ['required', 'in:info,warning,success,danger'],
            'target_audience' => ['required', 'in:all,students,specific'],
            'target_user_id' => ['nullable', 'exists:users,id'],
            'school_class_id' => ['nullable', 'exists:school_classes,id'],
        ]);

        $validated['is_active'] = true;
        $validated['created_by'] = auth()->id();
        $validated['published_at'] = now();

        Notification::create($validated);

        return redirect()->route('teacher.notifications.index')
            ->with('success', 'Notification sent successfully.');
    }
}
