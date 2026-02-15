@extends('layouts.app')

@section('content')
<div class="flex h-screen overflow-hidden">
    @include('partials.sidebar')

    <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
        @include('partials.overlay')
        @include('partials.header')

        <main>
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5 lg:p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Attendance Details</h3>
                    <a href="{{ route('admin.attendance.index') }}" class="text-sm text-brand-500 hover:text-brand-600">← Back to List</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Student Name</span>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $attendance->student->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Student Email</span>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $attendance->student->email ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Class</span>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $attendance->schoolClass->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Section</span>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $attendance->section->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Date</span>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $attendance->date->format('F d, Y') }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</span>
                            <p class="mt-1">
                                @php
                                    $statusColors = [
                                        'present' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400',
                                        'absent' => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400',
                                        'late' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400',
                                        'excused' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400',
                                    ];
                                @endphp
                                <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $statusColors[$attendance->status] ?? '' }}">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Remarks</span>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $attendance->remarks ?? 'No remarks' }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Marked By</span>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $attendance->markedBy->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Recorded At</span>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $attendance->created_at->format('M d, Y H:i A') }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-4">
                    <a href="{{ route('admin.attendance.edit', $attendance) }}" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600">Edit</a>
                    <form action="{{ route('admin.attendance.destroy', $attendance) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-lg border border-red-300 bg-white px-5 py-2.5 text-sm font-medium text-red-700 transition hover:bg-red-50 dark:border-red-600 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-red-900/20">Delete</button>
                    </form>
                </div>
            </div>
</main>
    </div>
</div>
@endsection