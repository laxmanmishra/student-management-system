@extends('layouts.app')

@section('content')
<div class="flex h-screen overflow-hidden">
    @include('partials.sidebar')

    <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
        @include('partials.overlay')
        @include('partials.header')

        <main>
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                @include('partials.breadcrumb')

                @if (session('success'))
                    <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-green-900/50 dark:text-green-400">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2">
                        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5 lg:p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Fee Details</h3>
                                <a href="{{ route('admin.fees.index') }}" class="text-sm text-brand-500 hover:text-brand-600">← Back to List</a>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Student Name</span>
                                        <p class="mt-1 text-gray-900 dark:text-white">{{ $fee->student->name ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Student Email</span>
                                        <p class="mt-1 text-gray-900 dark:text-white">{{ $fee->student->email ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Class</span>
                                        <p class="mt-1 text-gray-900 dark:text-white">{{ $fee->schoolClass->name ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Fee Type</span>
                                        <p class="mt-1">
                                            <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-400">
                                                {{ ucfirst($fee->fee_type) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Due Date</span>
                                        <p class="mt-1 text-gray-900 dark:text-white">{{ $fee->due_date->format('F d, Y') }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</span>
                                        <p class="mt-1">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400',
                                                    'partial' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400',
                                                    'paid' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400',
                                                    'overdue' => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400',
                                                ];
                                            @endphp
                                            <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $statusColors[$fee->status] ?? '' }}">
                                                {{ ucfirst($fee->status) }}
                                            </span>
                                        </p>
                                    </div>
                                    @if ($fee->paid_date)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Paid Date</span>
                                        <p class="mt-1 text-gray-900 dark:text-white">{{ $fee->paid_date->format('F d, Y') }}</p>
                                    </div>
                                    @endif
                                    @if ($fee->payment_method)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Payment Method</span>
                                        <p class="mt-1 text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $fee->payment_method)) }}</p>
                                    </div>
                                    @endif
                                    @if ($fee->collectedBy)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Collected By</span>
                                        <p class="mt-1 text-gray-900 dark:text-white">{{ $fee->collectedBy->name }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            @if ($fee->remarks)
                            <div class="mt-6">
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Remarks</span>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $fee->remarks }}</p>
                            </div>
                            @endif

                            <div class="mt-6 flex items-center gap-4">
                                <a href="{{ route('admin.fees.edit', $fee) }}" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600">Edit</a>
                                <form action="{{ route('admin.fees.destroy', $fee) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg border border-red-300 bg-white px-5 py-2.5 text-sm font-medium text-red-700 transition hover:bg-red-50 dark:border-red-600 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-red-900/20">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5 lg:p-6">
                            <h4 class="text-md font-semibold text-gray-800 dark:text-white/90 mb-4">Payment Summary</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">Total Amount</span>
                                    <span class="font-medium text-gray-900 dark:text-white">₹{{ number_format($fee->amount, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">Discount</span>
                                    <span class="font-medium text-green-600">- ₹{{ number_format($fee->discount, 2) }}</span>
                                </div>
                                <hr class="border-gray-200 dark:border-gray-700">
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">Net Amount</span>
                                    <span class="font-medium text-gray-900 dark:text-white">₹{{ number_format($fee->amount - $fee->discount, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">Paid Amount</span>
                                    <span class="font-medium text-green-600">₹{{ number_format($fee->paid_amount, 2) }}</span>
                                </div>
                                <hr class="border-gray-200 dark:border-gray-700">
                                <div class="flex justify-between text-lg">
                                    <span class="font-semibold text-gray-700 dark:text-gray-300">Balance Due</span>
                                    <span class="font-bold {{ $fee->balance > 0 ? 'text-red-600' : 'text-green-600' }}">₹{{ number_format($fee->balance, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        @if ($fee->status !== 'paid')
                        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5 lg:p-6">
                            <h4 class="text-md font-semibold text-gray-800 dark:text-white/90 mb-4">Record Payment</h4>
                            <form method="POST" action="{{ route('admin.fees.payment', $fee) }}">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <label for="paid_amount" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Amount (₹) <span class="text-red-500">*</span></label>
                                        <input type="number" name="paid_amount" id="paid_amount" required min="0.01" step="0.01" max="{{ $fee->balance }}" value="{{ $fee->balance }}" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                    </div>
                                    <div>
                                        <label for="payment_method" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Method <span class="text-red-500">*</span></label>
                                        <select name="payment_method" id="payment_method" required class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                            <option value="cash">Cash</option>
                                            <option value="card">Card</option>
                                            <option value="bank_transfer">Bank Transfer</option>
                                            <option value="cheque">Cheque</option>
                                            <option value="online">Online</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="transaction_id" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Transaction ID</label>
                                        <input type="text" name="transaction_id" id="transaction_id" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white" placeholder="Optional">
                                    </div>
                                    <button type="submit" class="w-full rounded-lg bg-green-500 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-green-600">Record Payment</button>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
