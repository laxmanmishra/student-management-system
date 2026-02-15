@extends('layouts.app')

@section('content')
<div class="flex h-screen overflow-hidden">
    @include('partials.sidebar')

    <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
        @include('partials.overlay')
        @include('partials.header')

        <main>
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Welcome to Student Management System</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Here's an overview of your school's current status</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6">
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 dark:bg-blue-900/30">
                            <svg class="fill-blue-600 dark:fill-blue-400" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.80443 5.60156C7.59109 5.60156 6.60749 6.58517 6.60749 7.79851C6.60749 9.01185 7.59109 9.99545 8.80443 9.99545C10.0178 9.99545 11.0014 9.01185 11.0014 7.79851C11.0014 6.58517 10.0178 5.60156 8.80443 5.60156ZM5.10749 7.79851C5.10749 5.75674 6.76267 4.10156 8.80443 4.10156C10.8462 4.10156 12.5014 5.75674 12.5014 7.79851C12.5014 9.84027 10.8462 11.4955 8.80443 11.4955C6.76267 11.4955 5.10749 9.84027 5.10749 7.79851ZM4.86252 15.3208C4.08769 16.0881 3.70377 17.0608 3.51705 17.8611C3.48384 18.0034 3.5211 18.1175 3.60712 18.2112C3.70161 18.3141 3.86659 18.3987 4.07591 18.3987H13.4249C13.6343 18.3987 13.7992 18.3141 13.8937 18.2112C13.9797 18.1175 14.017 18.0034 13.9838 17.8611C13.7971 17.0608 13.4132 16.0881 12.6383 15.3208C11.8821 14.572 10.6899 13.955 8.75042 13.955C6.81096 13.955 5.61877 14.572 4.86252 15.3208Z" fill=""/>
                            </svg>
                        </div>
                        <div class="mt-4">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Total Students</span>
                            <h4 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90">{{ number_format($totalStudents) }}</h4>
                        </div>
                        <a href="{{ route('admin.students.index') }}" class="mt-3 inline-flex text-sm text-brand-500 hover:text-brand-600">View all →</a>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 dark:bg-green-900/30">
                            <svg class="fill-green-600 dark:fill-green-400" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.5 2.01-4.5 4.5s2.01 4.5 4.5 4.5 4.5-2.01 4.5-4.5-2.01-4.5-4.5-4.5zm0 7c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5zM3 21.5h8v-8H3v8zm2-6h4v4H5v-4z" fill=""/>
                            </svg>
                        </div>
                        <div class="mt-4">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Total Teachers</span>
                            <h4 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90">{{ number_format($totalTeachers) }}</h4>
                        </div>
                        <a href="{{ route('admin.teachers.index') }}" class="mt-3 inline-flex text-sm text-brand-500 hover:text-brand-600">View all →</a>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-100 dark:bg-purple-900/30">
                            <svg class="fill-purple-600 dark:fill-purple-400" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" fill=""/>
                            </svg>
                        </div>
                        <div class="mt-4">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Classes / Sections</span>
                            <h4 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90">{{ $totalClasses }} / {{ $totalSections }}</h4>
                        </div>
                        <a href="{{ route('admin.classes.index') }}" class="mt-3 inline-flex text-sm text-brand-500 hover:text-brand-600">Manage →</a>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-100 dark:bg-orange-900/30">
                            <svg class="fill-orange-600 dark:fill-orange-400" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2l-5.5 9h11L12 2zm0 3.84L13.93 9h-3.87L12 5.84zM17.5 13c-2.49 0-4.5 2.01-4.5 4.5s2.01 4.5 4.5 4.5 4.5-2.01 4.5-4.5-2.01-4.5-4.5-4.5zm0 7c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5zM3 21.5h8v-8H3v8zm2-6h4v4H5v-4z" fill=""/>
                            </svg>
                        </div>
                        <div class="mt-4">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Total Subjects</span>
                            <h4 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90">{{ number_format($totalSubjects) }}</h4>
                        </div>
                        <a href="{{ route('admin.subjects.index') }}" class="mt-3 inline-flex text-sm text-brand-500 hover:text-brand-600">View all →</a>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6 mb-6">
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Today's Attendance</h3>
                            <span class="text-2xl font-bold {{ $attendanceRate >= 75 ? 'text-green-600' : ($attendanceRate >= 50 ? 'text-yellow-600' : 'text-red-600') }}">{{ $attendanceRate }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3 dark:bg-gray-700">
                            <div class="h-3 rounded-full {{ $attendanceRate >= 75 ? 'bg-green-600' : ($attendanceRate >= 50 ? 'bg-yellow-500' : 'bg-red-600') }}" style="width: {{ $attendanceRate }}%"></div>
                        </div>
                        <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">{{ $presentToday }} present out of {{ $todayAttendance }} marked</p>
                        <a href="{{ route('admin.attendance.report') }}" class="mt-3 inline-flex text-sm text-brand-500 hover:text-brand-600">View details →</a>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Fee Collection</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Collected</span>
                                <span class="text-lg font-semibold text-green-600">₹{{ number_format($collectedFees, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Pending</span>
                                <span class="text-lg font-semibold text-red-600">₹{{ number_format($pendingFees, 2) }}</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.fees.index') }}" class="mt-4 inline-flex text-sm text-brand-500 hover:text-brand-600">Manage fees →</a>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('admin.students.create') }}" class="flex items-center gap-2 p-3 rounded-lg bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 text-sm text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                Add Student
                            </a>
                            <a href="{{ route('admin.teachers.create') }}" class="flex items-center gap-2 p-3 rounded-lg bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 text-sm text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                Add Teacher
                            </a>
                            <a href="{{ route('admin.fees.create') }}" class="flex items-center gap-2 p-3 rounded-lg bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 text-sm text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Add Fee
                            </a>
                            <a href="{{ route('admin.notifications.create') }}" class="flex items-center gap-2 p-3 rounded-lg bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 text-sm text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                Send Notice
                            </a>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Upcoming Examinations</h3>
                            <a href="{{ route('admin.examinations.index') }}" class="text-sm text-brand-500 hover:text-brand-600">View all</a>
                        </div>
                        @if($upcomingExams->isEmpty())
                            <p class="text-sm text-gray-500 dark:text-gray-400">No upcoming examinations scheduled.</p>
                        @else
                            <div class="space-y-3">
                                @foreach($upcomingExams as $exam)
                                    <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-800">
                                        <div>
                                            <h4 class="font-medium text-gray-800 dark:text-white/90">{{ $exam->name }}</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $exam->subject->name ?? 'N/A' }} - {{ $exam->schoolClass->name ?? 'N/A' }}</p>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-sm font-medium text-brand-600">{{ $exam->exam_date->format('M d, Y') }}</span>
                                            <p class="text-xs text-gray-500">{{ $exam->start_time }} - {{ $exam->end_time }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Recent Notifications</h3>
                            <a href="{{ route('admin.notifications.index') }}" class="text-sm text-brand-500 hover:text-brand-600">View all</a>
                        </div>
                        @if($recentNotifications->isEmpty())
                            <p class="text-sm text-gray-500 dark:text-gray-400">No recent notifications.</p>
                        @else
                            <div class="space-y-3">
                                @foreach($recentNotifications as $notification)
                                    @php
                                        $typeColors = [
                                            'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400',
                                            'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400',
                                            'success' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400',
                                            'danger' => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400',
                                        ];
                                    @endphp
                                    <div class="flex items-start gap-3 p-3 rounded-lg bg-gray-50 dark:bg-gray-800">
                                        <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $typeColors[$notification->type] ?? '' }}">{{ ucfirst($notification->type) }}</span>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-medium text-gray-800 dark:text-white/90 truncate">{{ $notification->title }}</h4>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Recently Added Students</h3>
                            <a href="{{ route('admin.students.index') }}" class="text-sm text-brand-500 hover:text-brand-600">View all</a>
                        </div>
                        @if($recentStudents->isEmpty())
                            <p class="text-sm text-gray-500 dark:text-gray-400">No students added recently.</p>
                        @else
                            <div class="space-y-3">
                                @foreach($recentStudents as $student)
                                    <div class="flex items-center gap-3 p-3 rounded-lg bg-gray-50 dark:bg-gray-800">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-100 dark:bg-brand-900/30">
                                            <span class="text-sm font-semibold text-brand-600 dark:text-brand-400">{{ strtoupper(substr($student->name, 0, 2)) }}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-medium text-gray-800 dark:text-white/90 truncate">{{ $student->name }}</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $student->email }}</p>
                                        </div>
                                        <span class="text-xs text-gray-500">{{ $student->created_at->diffForHumans() }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Recent Fee Records</h3>
                            <a href="{{ route('admin.fees.index') }}" class="text-sm text-brand-500 hover:text-brand-600">View all</a>
                        </div>
                        @if($recentFees->isEmpty())
                            <p class="text-sm text-gray-500 dark:text-gray-400">No recent fee records.</p>
                        @else
                            <div class="space-y-3">
                                @foreach($recentFees as $fee)
                                    @php
                                        $statusColors = [
                                            'paid' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400',
                                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400',
                                            'partial' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400',
                                            'overdue' => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400',
                                        ];
                                    @endphp
                                    <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-800">
                                        <div>
                                            <h4 class="font-medium text-gray-800 dark:text-white/90">{{ $fee->student->name ?? 'N/A' }}</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ ucfirst($fee->fee_type) }}</p>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-sm font-medium text-gray-800 dark:text-white/90">₹{{ number_format($fee->amount, 2) }}</span>
                                            <span class="block text-xs rounded-full px-2 py-0.5 {{ $statusColors[$fee->status] ?? '' }}">{{ ucfirst($fee->status) }}</span>
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