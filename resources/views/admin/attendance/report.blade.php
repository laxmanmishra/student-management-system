@extends('layouts.app')

@section('content')
<div class="flex h-screen overflow-hidden">
    @include('partials.sidebar')

    <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
        @include('partials.overlay')
        @include('partials.header')

        <main>
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5 lg:p-6">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Attendance Report</h3>
                </div>

                <form method="GET" action="{{ route('admin.attendance.report') }}" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                    <select name="class_id" required class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        <option value="">Select Class</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                        @endforeach
                    </select>
                    <select name="section_id" required class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        <option value="">Select Section</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                        @endforeach
                    </select>
                    <input type="month" name="month" value="{{ request('month', date('Y-m')) }}" required class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600">Generate Report</button>
                </form>

                @if (count($report) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Student</th>
                                    <th class="px-4 py-3.5 text-center text-sm font-semibold text-green-600">Present</th>
                                    <th class="px-4 py-3.5 text-center text-sm font-semibold text-red-600">Absent</th>
                                    <th class="px-4 py-3.5 text-center text-sm font-semibold text-yellow-600">Late</th>
                                    <th class="px-4 py-3.5 text-center text-sm font-semibold text-blue-600">Excused</th>
                                    <th class="px-4 py-3.5 text-center text-sm font-semibold text-gray-900 dark:text-white">Total Days</th>
                                    <th class="px-4 py-3.5 text-center text-sm font-semibold text-gray-900 dark:text-white">Attendance %</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($report as $row)
                                    <tr>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $row['student']->name }}</td>
                                        <td class="whitespace-nowrap px-4 py-4 text-center text-sm text-green-600 font-medium">{{ $row['present'] }}</td>
                                        <td class="whitespace-nowrap px-4 py-4 text-center text-sm text-red-600 font-medium">{{ $row['absent'] }}</td>
                                        <td class="whitespace-nowrap px-4 py-4 text-center text-sm text-yellow-600 font-medium">{{ $row['late'] }}</td>
                                        <td class="whitespace-nowrap px-4 py-4 text-center text-sm text-blue-600 font-medium">{{ $row['excused'] }}</td>
                                        <td class="whitespace-nowrap px-4 py-4 text-center text-sm text-gray-700 dark:text-gray-300">{{ $row['total'] }}</td>
                                        <td class="whitespace-nowrap px-4 py-4 text-center text-sm font-medium">
                                            @php
                                                $percentage = $row['total'] > 0 ? round((($row['present'] + $row['late']) / $row['total']) * 100, 1) : 0;
                                                $colorClass = $percentage >= 75 ? 'text-green-600' : ($percentage >= 50 ? 'text-yellow-600' : 'text-red-600');
                                            @endphp
                                            <span class="{{ $colorClass }}">{{ $percentage }}%</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @elseif (request()->has('class_id'))
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        No attendance records found for the selected criteria.
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection