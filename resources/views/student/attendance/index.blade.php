@extends('layouts.app')

@section('content')
<div class="flex h-screen overflow-hidden">
    @include('partials.sidebar')
    <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
        @include('partials.overlay')
        @include('partials.header')
        <main>
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                <div x-data="{ pageName: `My Attendance`}">@include('partials.breadcrumb')</div>

                {{-- Summary Cards --}}
                @if($stats)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    @php
                        $total = $stats->total ?? 0;
                        $rate = $total > 0 ? round(($stats->present_count / $total) * 100, 1) : 0;
                    @endphp
                    <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Attendance Rate</p>
                        <p class="mt-1 text-2xl font-bold {{ $rate >= 75 ? 'text-green-600' : ($rate >= 50 ? 'text-yellow-600' : ($total > 0 ? 'text-red-600' : 'text-gray-800')) }}">
                            {{ $total > 0 ? $rate.'%' : 'N/A' }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">Overall</p>
                    </div>
                    <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Present</p>
                        <p class="mt-1 text-2xl font-bold text-green-600">{{ $stats->present_count ?? 0 }}</p>
                        <p class="text-xs text-gray-400 mt-1">days</p>
                    </div>
                    <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Absent</p>
                        <p class="mt-1 text-2xl font-bold text-red-600">{{ $stats->absent_count ?? 0 }}</p>
                        <p class="text-xs text-gray-400 mt-1">days</p>
                    </div>
                    <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Late</p>
                        <p class="mt-1 text-2xl font-bold text-yellow-600">{{ $stats->late_count ?? 0 }}</p>
                        <p class="text-xs text-gray-400 mt-1">days</p>
                    </div>
                </div>
                @if(isset($rate) && $rate < 75 && $total > 0)
                    <div class="mb-6 rounded-xl bg-red-50 p-4 text-sm text-red-700 dark:bg-red-900/20 dark:text-red-400">
                        ⚠ Your overall attendance is {{ $rate }}%, which is below the required 75%. Please attend classes regularly.
                    </div>
                @endif
                @endif

                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5 lg:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Attendance Records</h3>
                    </div>

                    <form method="GET" action="{{ route('student.attendance.index') }}" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <input type="month" name="month" value="{{ request('month') }}"
                               class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        <select name="status" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="">All Status</option>
                            <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Present</option>
                            <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                            <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Late</option>
                            <option value="excused" {{ request('status') == 'excused' ? 'selected' : '' }}>Excused</option>
                        </select>
                        <button type="submit" class="rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-900 dark:bg-white/10 dark:hover:bg-white/20">Filter</button>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Date</th>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Day</th>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Class</th>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Section</th>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Status</th>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Remarks</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($attendance as $record)
                                    @php
                                        $statusColors = [
                                            'present' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400',
                                            'absent'  => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400',
                                            'late'    => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400',
                                            'excused' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400',
                                        ];
                                    @endphp
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/30">
                                        <td class="whitespace-nowrap px-4 py-4 text-sm font-medium text-gray-800 dark:text-white/90">{{ $record->date->format('M d, Y') }}</td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $record->date->format('D') }}</td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $record->schoolClass->name ?? 'N/A' }}</td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $record->section->name ?? '—' }}</td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm">
                                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold {{ $statusColors[$record->status] ?? '' }}">
                                                {{ ucfirst($record->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $record->remarks ?? '—' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-10 text-center text-sm text-gray-500 dark:text-gray-400">No attendance records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">{{ $attendance->withQueryString()->links() }}</div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
