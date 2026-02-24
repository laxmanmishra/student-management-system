@extends('layouts.app')

@section('content')
<div class="flex h-screen overflow-hidden">
    @include('partials.sidebar')
    <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
        @include('partials.overlay')
        @include('partials.header')
        <main>
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                <div x-data="{ pageName: `My Examinations`}">@include('partials.breadcrumb')</div>

                @if(!$studentClassId)
                    <div class="mb-6 rounded-xl bg-yellow-50 p-4 text-sm text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400">
                        No class assigned yet. Examinations will appear once your teacher marks your attendance.
                    </div>
                @endif

                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5 lg:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Examination Schedule</h3>
                    </div>

                    <form method="GET" action="{{ route('student.examinations.index') }}" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <select name="exam_type" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="">All Types</option>
                            <option value="term" {{ request('exam_type') == 'term' ? 'selected' : '' }}>Term</option>
                            <option value="midterm" {{ request('exam_type') == 'midterm' ? 'selected' : '' }}>Midterm</option>
                            <option value="final" {{ request('exam_type') == 'final' ? 'selected' : '' }}>Final</option>
                            <option value="unit" {{ request('exam_type') == 'unit' ? 'selected' : '' }}>Unit Test</option>
                            <option value="quarterly" {{ request('exam_type') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                        </select>
                        <select name="filter" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="">All Exams</option>
                            <option value="upcoming" {{ request('filter') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                            <option value="past" {{ request('filter') == 'past' ? 'selected' : '' }}>Past</option>
                        </select>
                        <button type="submit" class="rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-900 dark:bg-white/10 dark:hover:bg-white/20">Filter</button>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Examination</th>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Type</th>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Subject</th>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Date</th>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Time</th>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Marks</th>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Status</th>
                                    <th class="px-4 py-3.5 text-right text-sm font-semibold text-gray-900 dark:text-white">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($examinations as $examination)
                                    @php
                                        $isUpcoming = $examination->exam_date->isFuture() || $examination->exam_date->isToday();
                                        $isToday = $examination->exam_date->isToday();
                                    @endphp
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/30 {{ $isToday ? 'bg-brand-50 dark:bg-brand-900/10' : '' }}">
                                        <td class="px-4 py-4 text-sm">
                                            <p class="font-medium text-gray-800 dark:text-white/90">{{ $examination->name }}</p>
                                            @if($isToday)
                                                <span class="inline-flex rounded-full px-1.5 py-0.5 text-xs font-semibold bg-brand-100 text-brand-700">Today!</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm">
                                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-400">
                                                {{ ucfirst($examination->exam_type) }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $examination->subject->name ?? 'N/A' }}</td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm font-medium {{ $isToday ? 'text-brand-600' : 'text-gray-700 dark:text-gray-300' }}">
                                            {{ $examination->exam_date->format('M d, Y') }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600 dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($examination->start_time)->format('h:i A') }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600 dark:text-gray-400">
                                            {{ $examination->total_marks }} / {{ $examination->passing_marks }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm">
                                            @if($isToday)
                                                <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold bg-brand-100 text-brand-700 dark:bg-brand-900/30 dark:text-brand-400">Today</span>
                                            @elseif($isUpcoming)
                                                <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400">Upcoming</span>
                                            @else
                                                <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400">Past</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4 text-right text-sm">
                                            <a href="{{ route('student.examinations.show', $examination) }}"
                                               class="rounded p-1.5 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-10 text-center text-sm text-gray-500 dark:text-gray-400">No examinations found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">{{ $examinations->withQueryString()->links() }}</div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
