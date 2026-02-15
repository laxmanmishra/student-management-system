@extends('layouts.app')

@section('content')
<div class="flex h-screen overflow-hidden">
    @include('partials.sidebar')

    <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
        @include('partials.overlay')
        @include('partials.header')

        <main>
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                <div x-data="{ pageName: `Examination`}">
                    @include('partials.breadcrumb')
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5 lg:p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Examination Details</h3>
                        <a href="{{ route('admin.examinations.index') }}" class="text-sm text-brand-500 hover:text-brand-600">← Back to List</a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Examination Name</span>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $examination->name }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Exam Type</span>
                                <p class="mt-1">
                                    <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-400">
                                        {{ ucfirst($examination->exam_type) }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Class</span>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $examination->schoolClass->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Subject</span>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $examination->subject->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</span>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $examination->description ?? 'No description' }}</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Exam Date</span>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $examination->exam_date->format('F d, Y') }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Time</span>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($examination->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($examination->end_time)->format('h:i A') }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Marks</span>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $examination->total_marks }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Passing Marks</span>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $examination->passing_marks }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</span>
                                <p class="mt-1">
                                    @if ($examination->is_active)
                                        <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400">Active</span>
                                    @else
                                        <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold bg-gray-100 text-gray-800 dark:bg-gray-900/50 dark:text-gray-400">Inactive</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Created By</span>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $examination->createdBy->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At</span>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $examination->created_at->format('M d, Y H:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center gap-4">
                        <a href="{{ route('admin.examinations.edit', $examination) }}" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600">Edit</a>
                        <form action="{{ route('admin.examinations.destroy', $examination) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg border border-red-300 bg-white px-5 py-2.5 text-sm font-medium text-red-700 transition hover:bg-red-50 dark:border-red-600 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-red-900/20">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
