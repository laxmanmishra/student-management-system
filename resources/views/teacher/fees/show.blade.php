@extends('layouts.app')

@section('content')
<div class="flex h-screen overflow-hidden">
    @include('partials.sidebar')
    <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
        @include('partials.overlay')
        @include('partials.header')
        <main>
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                <div x-data="{ pageName: `Fee Details`}">@include('partials.breadcrumb')</div>

                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5 lg:p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Fee Details</h3>
                        <a href="{{ route('teacher.fees.index') }}" class="text-sm text-brand-500 hover:text-brand-600">← Back to List</a>
                    </div>

                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400',
                            'partial'  => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400',
                            'paid'     => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400',
                            'overdue'  => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400',
                        ];
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Student</span>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $fee->student->name ?? 'N/A' }}</p>
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
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</span>
                                <p class="mt-1">
                                    <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $statusColors[$fee->status] ?? '' }}">
                                        {{ ucfirst($fee->status) }}
                                    </span>
                                </p>
                            </div>
                            @if ($fee->remarks)
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Remarks</span>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $fee->remarks }}</p>
                            </div>
                            @endif
                        </div>
                        <div class="space-y-4">
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Amount</span>
                                <p class="mt-1 text-xl font-bold text-gray-900 dark:text-white">₹{{ number_format($fee->amount, 2) }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Discount</span>
                                <p class="mt-1 text-gray-900 dark:text-white">₹{{ number_format($fee->discount, 2) }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Amount Paid</span>
                                <p class="mt-1 text-lg font-semibold text-green-600">₹{{ number_format($fee->paid_amount, 2) }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Balance Due</span>
                                <p class="mt-1 text-lg font-semibold {{ $fee->balance > 0 ? 'text-red-600' : 'text-green-600' }}">₹{{ number_format($fee->balance, 2) }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Due Date</span>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $fee->due_date->format('F d, Y') }}</p>
                            </div>
                            @if ($fee->paid_date)
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Paid On</span>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $fee->paid_date->format('F d, Y') }}</p>
                            </div>
                            @endif
                            @if ($fee->payment_method)
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Payment Method</span>
                                <p class="mt-1 text-gray-900 dark:text-white capitalize">{{ str_replace('_', ' ', $fee->payment_method) }}</p>
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
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
