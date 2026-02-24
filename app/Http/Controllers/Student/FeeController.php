<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeeController extends Controller
{
    public function index(Request $request): View
    {
        /** @var User $student */
        $student = auth()->user();

        $query = Fee::with(['schoolClass', 'collectedBy'])
            ->where('user_id', $student->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('fee_type')) {
            $query->where('fee_type', $request->fee_type);
        }

        $fees = $query->latest()->paginate(15);

        $summary = Fee::where('user_id', $student->id)
            ->selectRaw('
                SUM(amount) as total_amount,
                SUM(paid_amount) as total_paid,
                SUM(discount) as total_discount,
                COUNT(CASE WHEN status = "pending" THEN 1 END) as pending_count,
                COUNT(CASE WHEN status = "overdue" THEN 1 END) as overdue_count,
                COUNT(CASE WHEN status = "paid" THEN 1 END) as paid_count
            ')
            ->first();

        return view('student.fees.index', [
            'page' => 'My Fee Records',
            'fees' => $fees,
            'summary' => $summary,
        ]);
    }

    public function show(Fee $fee): View
    {
        $fee->load(['schoolClass', 'collectedBy']);

        return view('student.fees.show', [
            'page' => 'Fee Details',
            'fee' => $fee,
        ]);
    }
}
