@extends('layouts.app')

@section('content')
<div class="flex h-screen overflow-hidden">
    @include('partials.sidebar')
    <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
        @include('partials.overlay')
        @include('partials.header')
        <main>
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">

                {{-- Welcome --}}
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                        Welcome back, {{ $student->first_name ?? $student->name }}!
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Here's your academic summary for {{ now()->format('F Y') }}</p>
                </div>

                {{-- Stat Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6">

                    {{-- Attendance Rate --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl {{ $attendanceRate >= 75 ? 'bg-green-100 dark:bg-green-900/30' : ($attendanceRate >= 50 ? 'bg-yellow-100 dark:bg-yellow-900/30' : ($totalDays > 0 ? 'bg-red-100 dark:bg-red-900/30' : 'bg-gray-100 dark:bg-gray-800')) }}">
                            <svg class="{{ $attendanceRate >= 75 ? 'fill-green-600 dark:fill-green-400' : ($attendanceRate >= 50 ? 'fill-yellow-600 dark:fill-yellow-400' : ($totalDays > 0 ? 'fill-red-600 dark:fill-red-400' : 'fill-gray-500')) }}" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8 2C8.41421 2 8.75 2.33579 8.75 2.75V3.75H15.25V2.75C15.25 2.33579 15.5858 2 16 2C16.4142 2 16.75 2.33579 16.75 2.75V3.75H18.5C19.7426 3.75 20.75 4.75736 20.75 6V9V19C20.75 20.2426 19.7426 21.25 18.5 21.25H5.5C4.25736 21.25 3.25 20.2426 3.25 19V9V6C3.25 4.75736 4.25736 3.75 5.5 3.75H7.25V2.75C7.25 2.33579 7.58579 2 8 2ZM8 5.25H5.5C5.08579 5.25 4.75 5.58579 4.75 6V8.25H19.25V6C19.25 5.58579 18.9142 5.25 18.5 5.25H16H8ZM19.25 9.75H4.75V19C4.75 19.4142 5.08579 19.75 5.5 19.75H18.5C18.9142 19.75 19.25 19.4142 19.25 19V9.75Z"/>
                            </svg>
                        </div>
                        <div class="mt-4">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Attendance (This Month)</span>
                            <h4 class="mt-1 text-2xl font-bold {{ $attendanceRate >= 75 ? 'text-green-600' : ($attendanceRate >= 50 ? 'text-yellow-600' : ($totalDays > 0 ? 'text-red-600' : 'text-gray-800 dark:text-white/90')) }}">
                                {{ $totalDays > 0 ? $attendanceRate.'%' : 'N/A' }}
                            </h4>
                        </div>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $presentDays }} / {{ $totalDays }} days present</p>
                    </div>

                    {{-- Upcoming Exams --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-100 dark:bg-purple-900/30">
                            <svg class="fill-purple-600 dark:fill-purple-400" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H18.5C19.7426 20.75 20.75 19.7426 20.75 18.5V5.5C20.75 4.25736 19.7426 3.25 18.5 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H18.5C18.9142 4.75 19.25 5.08579 19.25 5.5V18.5C19.25 18.9142 18.9142 19.25 18.5 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V5.5ZM6.25 9.7C6.25 9.28579 6.58579 8.95 7 8.95H17C17.4142 8.95 17.75 9.28579 17.75 9.7C17.75 10.1142 17.4142 10.45 17 10.45H7C6.58579 10.45 6.25 10.1142 6.25 9.7ZM6.25 14.3C6.25 13.8858 6.58579 13.55 7 13.55H17C17.4142 13.55 17.75 13.8858 17.75 14.3C17.75 14.7142 17.4142 15.05 17 15.05H7C6.58579 15.05 6.25 14.7142 6.25 14.3Z"/>
                            </svg>
                        </div>
                        <div class="mt-4">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Upcoming Exams</span>
                            <h4 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90">{{ $upcomingExams->count() }}</h4>
                        </div>
                        <a href="{{ route('student.examinations.index') }}" class="mt-2 inline-flex text-sm text-brand-500 hover:text-brand-600">View schedule →</a>
                    </div>

                    {{-- Fee Balance --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl {{ $totalBalance > 0 ? 'bg-red-100 dark:bg-red-900/30' : 'bg-green-100 dark:bg-green-900/30' }}">
                            <svg class="{{ $totalBalance > 0 ? 'fill-red-600 dark:fill-red-400' : 'fill-green-600 dark:fill-green-400' }}" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C12.4142 2 12.75 2.33579 12.75 2.75V4.03078C15.5686 4.37932 17.75 6.81126 17.75 9.75V10.25C17.75 10.6642 17.4142 11 17 11C16.5858 11 16.25 10.6642 16.25 10.25V9.75C16.25 7.40279 14.3472 5.5 12 5.5C9.65279 5.5 7.75 7.40279 7.75 9.75V14.25C7.75 16.5972 9.65279 18.5 12 18.5C14.3472 18.5 16.25 16.5972 16.25 14.25V13.75C16.25 13.3358 16.5858 13 17 13C17.4142 13 17.75 13.3358 17.75 13.75V14.25C17.75 17.1887 15.5686 19.6207 12.75 19.9692V21.25C12.75 21.6642 12.4142 22 12 22C11.5858 22 11.25 21.6642 11.25 21.25V19.9692C8.43139 19.6207 6.25 17.1887 6.25 14.25V9.75C6.25 6.81126 8.43139 4.37932 11.25 4.03078V2.75C11.25 2.33579 11.5858 2 12 2Z"/>
                            </svg>
                        </div>
                        <div class="mt-4">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Fee Balance Due</span>
                            <h4 class="mt-1 text-2xl font-bold {{ $totalBalance > 0 ? 'text-red-600' : 'text-green-600' }}">
                                ₹{{ number_format($totalBalance, 0) }}
                            </h4>
                        </div>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $pendingFeesCount }} pending fee(s)</p>
                    </div>

                    {{-- Notifications --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 dark:bg-blue-900/30">
                            <svg class="fill-blue-600 dark:fill-blue-400" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C8.68629 2 6 4.68629 6 8V9.58579L4.29289 11.2929C4.10536 11.4804 4 11.7348 4 12V15C4 15.5523 4.44772 16 5 16H8.17071C8.58254 17.1652 9.69378 18 11 18H13C14.3062 18 15.4175 17.1652 15.8293 16H19C19.5523 16 20 15.5523 20 15V12C20 11.7348 19.8946 11.4804 19.7071 11.2929L18 9.58579V8C18 4.68629 15.3137 2 12 2ZM14 16H10C9.44772 16 9 15.5523 9 15V14H15V15C15 15.5523 14.5523 16 14 16ZM16 12V8C16 5.79086 14.2091 4 12 4C9.79086 4 8 5.79086 8 8V12L6.41421 13.5858L6 14H18L17.5858 13.5858L16 12ZM12 20C10.8954 20 10 20.8954 10 22H14C14 20.8954 13.1046 20 12 20Z"/>
                            </svg>
                        </div>
                        <div class="mt-4">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Notifications</span>
                            <h4 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90">{{ $recentNotifications->count() }}</h4>
                        </div>
                        <a href="{{ route('student.notifications.index') }}" class="mt-2 inline-flex text-sm text-brand-500 hover:text-brand-600">View all →</a>
                    </div>
                </div>

                {{-- Middle Row --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6 mb-6">

                    {{-- Attendance Summary --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <h3 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">Attendance This Month</h3>
                        @if($totalDays > 0)
                            <div class="mb-3">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Attendance Rate</span>
                                    <span class="text-sm font-bold {{ $attendanceRate >= 75 ? 'text-green-600' : ($attendanceRate >= 50 ? 'text-yellow-600' : 'text-red-600') }}">{{ $attendanceRate }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                    <div class="h-2.5 rounded-full {{ $attendanceRate >= 75 ? 'bg-green-500' : ($attendanceRate >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}" style="width: {{ $attendanceRate }}%"></div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div class="flex items-center gap-2 rounded-lg bg-green-50 p-2 dark:bg-green-900/20">
                                    <span class="h-2 w-2 rounded-full bg-green-500 shrink-0"></span>
                                    <span class="text-gray-700 dark:text-gray-300">Present: <strong>{{ $presentDays }}</strong></span>
                                </div>
                                <div class="flex items-center gap-2 rounded-lg bg-red-50 p-2 dark:bg-red-900/20">
                                    <span class="h-2 w-2 rounded-full bg-red-500 shrink-0"></span>
                                    <span class="text-gray-700 dark:text-gray-300">Absent: <strong>{{ $absentDays }}</strong></span>
                                </div>
                                <div class="flex items-center gap-2 rounded-lg bg-yellow-50 p-2 dark:bg-yellow-900/20">
                                    <span class="h-2 w-2 rounded-full bg-yellow-500 shrink-0"></span>
                                    <span class="text-gray-700 dark:text-gray-300">Late: <strong>{{ $lateDays }}</strong></span>
                                </div>
                                <div class="flex items-center gap-2 rounded-lg bg-blue-50 p-2 dark:bg-blue-900/20">
                                    <span class="h-2 w-2 rounded-full bg-blue-500 shrink-0"></span>
                                    <span class="text-gray-700 dark:text-gray-300">Total: <strong>{{ $totalDays }}</strong></span>
                                </div>
                            </div>
                            @if($attendanceRate < 75)
                                <p class="mt-3 text-xs text-red-600 dark:text-red-400 font-medium">⚠ Your attendance is below 75%. Please attend regularly.</p>
                            @endif
                        @else
                            <div class="flex flex-col items-center justify-center py-6 text-center">
                                <p class="text-sm text-gray-500 dark:text-gray-400">No attendance records this month.</p>
                            </div>
                        @endif
                    </div>

                    {{-- Fee Summary --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <h3 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">Fee Summary</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Total Fees</span>
                                <span class="text-sm font-semibold text-gray-800 dark:text-white">₹{{ number_format($totalFeeAmount, 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Amount Paid</span>
                                <span class="text-sm font-semibold text-green-600">₹{{ number_format($totalPaidAmount, 2) }}</span>
                            </div>
                            <div class="border-t border-gray-100 dark:border-gray-800 pt-3 flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Balance Due</span>
                                <span class="text-base font-bold {{ $totalBalance > 0 ? 'text-red-600' : 'text-green-600' }}">₹{{ number_format($totalBalance, 2) }}</span>
                            </div>
                        </div>
                        @if($overdueFeesCount > 0)
                            <div class="mt-3 rounded-lg bg-red-50 p-3 dark:bg-red-900/20">
                                <p class="text-xs font-medium text-red-700 dark:text-red-400">⚠ {{ $overdueFeesCount }} overdue fee(s). Please pay immediately.</p>
                            </div>
                        @endif
                        <a href="{{ route('student.fees.index') }}" class="mt-4 block text-center rounded-lg border border-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                            View All Fees
                        </a>
                    </div>

                    {{-- Quick Actions --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <h3 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">Quick Actions</h3>
                        <div class="grid grid-cols-1 gap-2">
                            <a href="{{ route('student.attendance.index') }}"
                               class="flex items-center gap-3 rounded-lg bg-brand-50 p-3 text-sm font-medium text-brand-700 transition hover:bg-brand-100 dark:bg-brand-900/20 dark:text-brand-400 dark:hover:bg-brand-900/30">
                                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                                View Attendance
                            </a>
                            <a href="{{ route('student.examinations.index') }}"
                               class="flex items-center gap-3 rounded-lg bg-gray-50 p-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Exam Schedule
                            </a>
                            <a href="{{ route('student.fees.index') }}"
                               class="flex items-center gap-3 rounded-lg bg-gray-50 p-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Fee Status
                            </a>
                            <a href="{{ route('student.notifications.index') }}"
                               class="flex items-center gap-3 rounded-lg bg-gray-50 p-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                Notifications
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Bottom Row --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">

                    {{-- Upcoming Examinations --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Upcoming Examinations</h3>
                            <a href="{{ route('student.examinations.index') }}" class="text-sm text-brand-500 hover:text-brand-600">View all</a>
                        </div>
                        @if($upcomingExams->isEmpty())
                            <p class="text-sm text-gray-500 dark:text-gray-400">No upcoming examinations scheduled.</p>
                        @else
                            <div class="space-y-3">
                                @foreach($upcomingExams as $exam)
                                    <div class="flex items-center justify-between rounded-lg bg-gray-50 p-3 dark:bg-gray-800">
                                        <div>
                                            <p class="font-medium text-sm text-gray-800 dark:text-white/90">{{ $exam->name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $exam->subject->name ?? 'N/A' }}
                                                @if($exam->schoolClass)· {{ $exam->schoolClass->name }}@endif
                                            </p>
                                        </div>
                                        <div class="text-right shrink-0 ml-2">
                                            <span class="text-sm font-semibold text-brand-600">{{ $exam->exam_date->format('M d') }}</span>
                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($exam->start_time)->format('h:i A') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Recent Attendance --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Recent Attendance</h3>
                            <a href="{{ route('student.attendance.index') }}" class="text-sm text-brand-500 hover:text-brand-600">View all</a>
                        </div>
                        @if($recentAttendance->isEmpty())
                            <p class="text-sm text-gray-500 dark:text-gray-400">No attendance records yet.</p>
                        @else
                            <div class="space-y-2">
                                @foreach($recentAttendance as $record)
                                    @php
                                        $statusColors = [
                                            'present' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400',
                                            'absent'  => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400',
                                            'late'    => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400',
                                            'excused' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400',
                                        ];
                                    @endphp
                                    <div class="flex items-center justify-between rounded-lg bg-gray-50 px-3 py-2.5 dark:bg-gray-800">
                                        <div>
                                            <p class="text-sm text-gray-800 dark:text-white/90">{{ $record->date->format('D, M d Y') }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $record->schoolClass->name ?? '' }}
                                                @if($record->section)· {{ $record->section->name }}@endif
                                            </p>
                                        </div>
                                        <span class="shrink-0 ml-2 inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $statusColors[$record->status] ?? '' }}">
                                            {{ ucfirst($record->status) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Recent Notifications --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:col-span-2">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Recent Notifications</h3>
                            <a href="{{ route('student.notifications.index') }}" class="text-sm text-brand-500 hover:text-brand-600">View all</a>
                        </div>
                        @if($recentNotifications->isEmpty())
                            <p class="text-sm text-gray-500 dark:text-gray-400">No notifications at the moment.</p>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($recentNotifications as $notification)
                                    @php
                                        $typeColors = [
                                            'info'    => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400',
                                            'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400',
                                            'success' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400',
                                            'danger'  => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400',
                                        ];
                                    @endphp
                                    <a href="{{ route('student.notifications.show', $notification) }}"
                                       class="flex items-start gap-3 rounded-lg bg-gray-50 p-3 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 transition">
                                        <span class="shrink-0 mt-0.5 inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $typeColors[$notification->type] ?? '' }}">
                                            {{ ucfirst($notification->type) }}
                                        </span>
                                        <div class="min-w-0 flex-1">
                                            <p class="truncate text-sm font-medium text-gray-800 dark:text-white/90">{{ $notification->title }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
