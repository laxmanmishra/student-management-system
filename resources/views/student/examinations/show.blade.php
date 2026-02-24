@extends('layouts.app')

@section('content')
<div class="flex h-screen overflow-hidden">
    @include('partials.sidebar')
    <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
        @include('partials.overlay')
        @include('partials.header')
        <main>
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                <div x-data="{ pageName: `Examination Details`}">@include('partials.breadcrumb')</div>

                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5 lg:p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Examination Details</h3>
                        <a href="{{ route('student.examinations.index') }}" class="text-sm text-brand-500 hover:text-brand-600">← Back to List</a>
                    </div>

                    @php
                        $isUpcoming = $examination->exam_date->isFuture() || $examination->exam_date->isToday();
                        $isToday = $examination->exam_date->isToday();
                        $daysUntil = now()->diffInDays($examination->exam_date, false);
                    @endphp

                    @if($isToday)
                        <div class="mb-6 rounded-xl bg-brand-50 p-4 text-sm font-medium text-brand-700 dark:bg-brand-900/20 dark:text-brand-400">
                            📝 This exam is today! Be prepared.
                        </div>
                    @elseif($isUpcoming && $daysUntil <= 7)
                        <div class="mb-6 rounded-xl bg-yellow-50 p-4 text-sm font-medium text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400">
                            ⏰ Only {{ $daysUntil }} day(s) left. Start preparing now!
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Examination Name</span>
                                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $examination->name }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Type</span>
                                <p class="mt-1">
                                    <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-400">
                                        {{ ucfirst($examination->exam_type) }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Subject</span>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $examination->subject->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Class</span>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $examination->schoolClass->name ?? 'N/A' }}</p>
                            </div>
                            @if($examination->description)
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Instructions / Description</span>
                                <p class="mt-1 text-gray-900 dark:text-white text-sm">{{ $examination->description }}</p>
                            </div>
                            @endif
                        </div>
                        <div class="space-y-4">
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Exam Date</span>
                                <p class="mt-1 text-gray-900 dark:text-white font-medium">{{ $examination->exam_date->format('l, F d, Y') }}</p>
                                @if($isUpcoming && !$isToday)
                                    <p class="text-xs text-brand-500 mt-0.5">{{ $daysUntil }} day(s) from now</p>
                                @endif
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Time</span>
                                <p class="mt-1 text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($examination->start_time)->format('h:i A') }} –
                                    {{ \Carbon\Carbon::parse($examination->end_time)->format('h:i A') }}
                                </p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="rounded-xl bg-gray-50 p-3 dark:bg-gray-800 text-center">
                                    <p class="text-xs text-gray-500">Total Marks</p>
                                    <p class="mt-1 text-2xl font-bold text-gray-800 dark:text-white">{{ $examination->total_marks }}</p>
                                </div>
                                <div class="rounded-xl bg-green-50 p-3 dark:bg-green-900/20 text-center">
                                    <p class="text-xs text-gray-500">Passing Marks</p>
                                    <p class="mt-1 text-2xl font-bold text-green-600">{{ $examination->passing_marks }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
