<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        /** @var User $student */
        $student = auth()->user();

        $query = Notification::with(['createdBy'])
            ->where('is_active', true)
            ->where(function ($q) use ($student) {
                $q->whereIn('target_audience', ['all', 'students'])
                    ->orWhere('target_user_id', $student->id);
            });

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $notifications = $query->latest()->paginate(15);

        return view('student.notifications.index', [
            'page' => 'Notifications',
            'notifications' => $notifications,
        ]);
    }

    public function show(Notification $notification): View
    {
        $notification->load(['createdBy']);

        return view('student.notifications.show', [
            'page' => 'Notification Details',
            'notification' => $notification,
        ]);
    }
}
