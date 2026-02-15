<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Fee::with(['student', 'schoolClass', 'collectedBy']);

        if ($request->filled('class_id')) {
            $query->where('school_class_id', $request->class_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('fee_type')) {
            $query->where('fee_type', $request->fee_type);
        }

        if ($request->filled('student_id')) {
            $query->where('user_id', $request->student_id);
        }

        $fees = $query->latest()->paginate(15);
        $classes = SchoolClass::where('is_active', true)->get();
        $students = User::where('role', 'student')->get();

        return view('admin.fees.index', compact('fees', 'classes', 'students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $classes = SchoolClass::where('is_active', true)->get();
        $students = User::where('role', 'student')->get();

        return view('admin.fees.create', compact('classes', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'school_class_id' => ['required', 'exists:school_classes,id'],
            'fee_type' => ['required', 'string', 'in:tuition,admission,exam,library,transport,lab,sports,other'],
            'amount' => ['required', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'due_date' => ['required', 'date'],
            'remarks' => ['nullable', 'string'],
        ]);

        $validated['discount'] = $validated['discount'] ?? 0;
        $validated['status'] = 'pending';

        Fee::create($validated);

        return redirect()->route('admin.fees.index')
            ->with('success', 'Fee record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fee $fee): View
    {
        $fee->load(['student', 'schoolClass', 'collectedBy']);

        return view('admin.fees.show', compact('fee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fee $fee): View
    {
        $classes = SchoolClass::where('is_active', true)->get();
        $students = User::where('role', 'student')->get();

        return view('admin.fees.edit', compact('fee', 'classes', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fee $fee): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'school_class_id' => ['required', 'exists:school_classes,id'],
            'fee_type' => ['required', 'string', 'in:tuition,admission,exam,library,transport,lab,sports,other'],
            'amount' => ['required', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'due_date' => ['required', 'date'],
            'remarks' => ['nullable', 'string'],
        ]);

        $validated['discount'] = $validated['discount'] ?? 0;

        $fee->update($validated);

        return redirect()->route('admin.fees.index')
            ->with('success', 'Fee record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fee $fee): RedirectResponse
    {
        $fee->delete();

        return redirect()->route('admin.fees.index')
            ->with('success', 'Fee record deleted successfully.');
    }

    /**
     * Record a payment for a fee.
     */
    public function recordPayment(Request $request, Fee $fee): RedirectResponse
    {
        $validated = $request->validate([
            'paid_amount' => ['required', 'numeric', 'min:0.01'],
            'payment_method' => ['required', 'string', 'in:cash,card,bank_transfer,cheque,online'],
            'transaction_id' => ['nullable', 'string'],
            'remarks' => ['nullable', 'string'],
        ]);

        $newPaidAmount = $fee->paid_amount + $validated['paid_amount'];
        $totalDue = $fee->amount - $fee->discount;

        $fee->update([
            'paid_amount' => $newPaidAmount,
            'payment_method' => $validated['payment_method'],
            'transaction_id' => $validated['transaction_id'],
            'remarks' => $validated['remarks'] ?? $fee->remarks,
            'paid_date' => now(),
            'collected_by' => auth()->id(),
            'status' => $newPaidAmount >= $totalDue ? 'paid' : 'partial',
        ]);

        return redirect()->route('admin.fees.show', $fee)
            ->with('success', 'Payment recorded successfully.');
    }
}
