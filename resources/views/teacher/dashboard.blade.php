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
                        Welcome back, {{ $teacher->first_name ?? $teacher->name }}!
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Here's your teaching summary for today</p>
                </div>

                {{-- Stat Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6">
                    {{-- My Classes --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 dark:bg-blue-900/30">
                            <svg class="fill-blue-600 dark:fill-blue-400" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" fill=""/>
                            </svg>
                        </div>
                        <div class="mt-4">
                            <span class="text-sm text-gray-500 dark:text-gray-400">My Classes</span>
                            <h4 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90">{{ $myClasses->count() }}</h4>
                        </div>
                        <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">Assigned as class teacher</p>
                    </div>

                    {{-- My Subjects --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-100 dark:bg-purple-900/30">
                            <svg class="fill-purple-600 dark:fill-purple-400" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2l-5.5 9h11L12 2zm0 3.84L13.93 9h-3.87L12 5.84zM17.5 13c-2.49 0-4.5 2.01-4.5 4.5S15.01 22 17.5 22s4.5-2.01 4.5-4.5-2.01-4.5-4.5-4.5zm0 7c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5zM3 21.5h8v-8H3v8zm2-6h4v4H5v-4z" fill=""/>
                            </svg>
                        </div>
                        <div class="mt-4">
                            <span class="text-sm text-gray-500 dark:text-gray-400">My Subjects</span>
                            <h4 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90">{{ $mySubjects->count() }}</h4>
                        </div>
                        <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">Teaching this term</p>
                    </div>

                    {{-- Total Students --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 dark:bg-green-900/30">
                            <svg class="fill-green-600 dark:fill-green-400" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.80443 5.60156C7.59109 5.60156 6.60749 6.58517 6.60749 7.79851C6.60749 9.01185 7.59109 9.99545 8.80443 9.99545C10.0178 9.99545 11.0014 9.01185 11.0014 7.79851C11.0014 6.58517 10.0178 5.60156 8.80443 5.60156ZM5.10749 7.79851C5.10749 5.75674 6.76267 4.10156 8.80443 4.10156C10.8462 4.10156 12.5014 5.75674 12.5014 7.79851C12.5014 9.84027 10.8462 11.4955 8.80443 11.4955C6.76267 11.4955 5.10749 9.84027 5.10749 7.79851ZM4.86252 15.3208C4.08769 16.0881 3.70377 17.0608 3.51705 17.8611C3.48384 18.0034 3.5211 18.1175 3.60712 18.2112C3.70161 18.3141 3.86659 18.3987 4.07591 18.3987H13.4249C13.6343 18.3987 13.7992 18.3141 13.8937 18.2112C13.9797 18.1175 14.017 18.0034 13.9838 17.8611C13.7971 17.0608 13.4132 16.0881 12.6383 15.3208C11.8821 14.572 10.6899 13.955 8.75042 13.955C6.81096 13.955 5.61877 14.572 4.86252 15.3208Z" fill=""/>
                            </svg>
                        </div>
                        <div class="mt-4">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Total Students</span>
                            <h4 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90">{{ number_format($totalStudents) }}</h4>
                        </div>
                        <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">Enrolled in school</p>
                    </div>

                    {{-- Today's Attendance --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-100 dark:bg-orange-900/30">
                            <svg class="fill-orange-600 dark:fill-orange-400" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8 2C8.41421 2 8.75 2.33579 8.75 2.75V3.75H15.25V2.75C15.25 2.33579 15.5858 2 16 2C16.4142 2 16.75 2.33579 16.75 2.75V3.75H18.5C19.7426 3.75 20.75 4.75736 20.75 6V9V19C20.75 20.2426 19.7426 21.25 18.5 21.25H5.5C4.25736 21.25 3.25 20.2426 3.25 19V9V6C3.25 4.75736 4.25736 3.75 5.5 3.75H7.25V2.75C7.25 2.33579 7.58579 2 8 2ZM8 5.25H5.5C5.08579 5.25 4.75 5.58579 4.75 6V8.25H19.25V6C19.25 5.58579 18.9142 5.25 18.5 5.25H16H8ZM19.25 9.75H4.75V19C4.75 19.4142 5.08579 19.75 5.5 19.75H18.5C18.9142 19.75 19.25 19.4142 19.25 19V9.75Z" fill=""/>
                            </svg>
                        </div>
                        <div class="mt-4">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Today's Attendance</span>
                            <h4 class="mt-1 text-2xl font-bold {{ $todayAttendanceRate >= 75 ? 'text-green-600' : ($todayAttendanceRate >= 50 ? 'text-yellow-600' : ($todayMarkedCount > 0 ? 'text-red-600' : 'text-gray-800 dark:text-white/90')) }}">
                                {{ $todayMarkedCount > 0 ? $todayAttendanceRate.'%' : '—' }}
                            </h4>
                        </div>
                        <a href="{{ route('teacher.attendance.create') }}" class="mt-3 inline-flex text-sm text-brand-500 hover:text-brand-600">
                            {{ $todayMarkedCount > 0 ? 'View records →' : 'Mark now →' }}
                        </a>
                    </div>
                </div>

                {{-- Middle Row: Attendance Progress + Quick Actions --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6 mb-6">

                    {{-- Today's Attendance Bar --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Today's Attendance</h3>
                            @if($todayMarkedCount > 0)
                                <span class="text-xl font-bold {{ $todayAttendanceRate >= 75 ? 'text-green-600' : ($todayAttendanceRate >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $todayAttendanceRate }}%
                                </span>
                            @endif
                        </div>
                        @if($todayMarkedCount > 0)
                            <div class="w-full bg-gray-200 rounded-full h-3 dark:bg-gray-700 mb-3">
                                <div class="h-3 rounded-full {{ $todayAttendanceRate >= 75 ? 'bg-green-500' : ($todayAttendanceRate >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                     style="width: {{ $todayAttendanceRate }}%"></div>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div class="flex items-center gap-2">
                                    <span class="h-2 w-2 rounded-full bg-green-500"></span>
                                    <span class="text-gray-600 dark:text-gray-400">Present: <strong class="text-gray-800 dark:text-white">{{ $todayPresentCount }}</strong></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="h-2 w-2 rounded-full bg-red-500"></span>
                                    <span class="text-gray-600 dark:text-gray-400">Absent: <strong class="text-gray-800 dark:text-white">{{ $todayMarkedCount - $todayPresentCount }}</strong></span>
                                </div>
                            </div>
                            <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">{{ $todayMarkedCount }} record(s) marked today</p>
                        @else
                            <div class="flex flex-col items-center justify-center py-6 text-center">
                                <svg class="mb-3 h-10 w-10 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-sm text-gray-500 dark:text-gray-400">No attendance marked today</p>
                                <a href="{{ route('teacher.attendance.create') }}"
                                   class="mt-3 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600">
                                    Mark Attendance
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- My Classes --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <h3 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">My Classes</h3>
                        @if($myClasses->isEmpty())
                            <p class="text-sm text-gray-500 dark:text-gray-400">No classes assigned yet.</p>
                        @else
                            <div class="space-y-2">
                                @foreach($myClasses as $class)
                                    <div class="flex items-center justify-between rounded-lg bg-gray-50 px-3 py-2.5 dark:bg-gray-800">
                                        <div class="flex items-center gap-2">
                                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-700 dark:bg-blue-900/40 dark:text-blue-400">
                                                {{ $loop->iteration }}
                                            </span>
                                            <span class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $class->name }}</span>
                                        </div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $class->sections_count }} section(s)</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Quick Actions --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <h3 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">Quick Actions</h3>
                        <div class="grid grid-cols-1 gap-2">
                            <a href="{{ route('teacher.attendance.create') }}"
                               class="flex items-center gap-3 rounded-lg bg-brand-50 p-3 text-sm font-medium text-brand-700 transition hover:bg-brand-100 dark:bg-brand-900/20 dark:text-brand-400 dark:hover:bg-brand-900/30">
                                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                                Mark Attendance
                            </a>
                            <a href="{{ route('teacher.attendance.index') }}"
                               class="flex items-center gap-3 rounded-lg bg-gray-50 p-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                </svg>
                                View Attendance Records
                            </a>
                            <a href="{{ route('teacher.attendance.report') }}"
                               class="flex items-center gap-3 rounded-lg bg-gray-50 p-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Monthly Report
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Bottom Row --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">

                    {{-- My Subjects --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <h3 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">My Subjects</h3>
                        @if($mySubjects->isEmpty())
                            <p class="text-sm text-gray-500 dark:text-gray-400">No subjects assigned yet.</p>
                        @else
                            <div class="space-y-2">
                                @foreach($mySubjects as $subject)
                                    <div class="flex items-center justify-between rounded-lg bg-gray-50 px-3 py-2.5 dark:bg-gray-800">
                                        <div>
                                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $subject->name }}</p>
                                            @if($subject->code)
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Code: {{ $subject->code }}</p>
                                            @endif
                                        </div>
                                        @if($subject->schoolClasses->isNotEmpty())
                                            <div class="flex flex-wrap gap-1 justify-end">
                                                @foreach($subject->schoolClasses->take(3) as $class)
                                                    <span class="rounded-full bg-purple-100 px-2 py-0.5 text-xs text-purple-700 dark:bg-purple-900/30 dark:text-purple-400">
                                                        {{ $class->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Upcoming Examinations --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <h3 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">Upcoming Examinations</h3>
                        @if($upcomingExams->isEmpty())
                            <p class="text-sm text-gray-500 dark:text-gray-400">No upcoming examinations scheduled.</p>
                        @else
                            <div class="space-y-3">
                                @foreach($upcomingExams as $exam)
                                    <div class="flex items-center justify-between rounded-lg bg-gray-50 p-3 dark:bg-gray-800">
                                        <div>
                                            <p class="font-medium text-gray-800 dark:text-white/90">{{ $exam->name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $exam->subject->name ?? 'N/A' }}
                                                @if($exam->schoolClass)
                                                    · {{ $exam->schoolClass->name }}
                                                @endif
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-sm font-medium text-brand-600">{{ $exam->exam_date->format('M d') }}</span>
                                            <p class="text-xs text-gray-500">{{ $exam->start_time }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Recent Attendance Marked --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Recent Attendance Marked</h3>
                            <a href="{{ route('teacher.attendance.index') }}" class="text-sm text-brand-500 hover:text-brand-600">View all</a>
                        </div>
                        @if($recentAttendance->isEmpty())
                            <p class="text-sm text-gray-500 dark:text-gray-400">No attendance records yet.</p>
                        @else
                            <div class="space-y-2">
                                @foreach($recentAttendance as $record)
                                    @php
                                        $statusColors = [
                                            'present' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400',
                                            'absent' => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400',
                                            'late' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400',
                                            'excused' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400',
                                        ];
                                    @endphp
                                    <div class="flex items-center justify-between rounded-lg bg-gray-50 px-3 py-2.5 dark:bg-gray-800">
                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-medium text-gray-800 dark:text-white/90">{{ $record->student->name ?? 'N/A' }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $record->schoolClass->name ?? '' }}
                                                @if($record->section)
                                                    · {{ $record->section->name }}
                                                @endif
                                                · {{ $record->date->format('M d, Y') }}
                                            </p>
                                        </div>
                                        <span class="ml-3 shrink-0 inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $statusColors[$record->status] ?? '' }}">
                                            {{ ucfirst($record->status) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Recent Notifications --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <h3 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">Recent Notifications</h3>
                        @if($recentNotifications->isEmpty())
                            <p class="text-sm text-gray-500 dark:text-gray-400">No notifications.</p>
                        @else
                            <div class="space-y-3">
                                @foreach($recentNotifications as $notification)
                                    @php
                                        $typeColors = [
                                            'info'    => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400',
                                            'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400',
                                            'success' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400',
                                            'danger'  => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400',
                                        ];
                                    @endphp
                                    <div class="flex items-start gap-3 rounded-lg bg-gray-50 p-3 dark:bg-gray-800">
                                        <span class="shrink-0 inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $typeColors[$notification->type] ?? '' }}">
                                            {{ ucfirst($notification->type) }}
                                        </span>
                                        <div class="min-w-0 flex-1">
                                            <p class="truncate text-sm font-medium text-gray-800 dark:text-white/90">{{ $notification->title }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
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
