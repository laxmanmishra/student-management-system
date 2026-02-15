@extends('layouts.app')

@section('content')
<div class="flex h-screen overflow-hidden">
    @include('partials.sidebar')

    <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
        @include('partials.overlay')
        @include('partials.header')

        <main>
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                @include('partials.breadcrumb')

                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4 dark:border-gray-800 sm:px-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Teacher Details</h3>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.teachers.edit', $teacher) }}"
                               class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </a>
                            <a href="{{ route('admin.teachers.index') }}"
                               class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                                Back to List
                            </a>
                        </div>
                    </div>

                    <div class="p-5 sm:p-6">
                        <div class="flex flex-col items-center gap-6 md:flex-row md:items-start">
                            <div class="h-32 w-32 overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                                @if($teacher->avatar)
                                    <img src="{{ Storage::url($teacher->avatar) }}" alt="{{ $teacher->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-4xl font-medium text-gray-600 dark:text-gray-300">
                                        {{ strtoupper(substr($teacher->first_name ?? $teacher->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1">
                                <h2 class="mb-1 text-2xl font-bold text-gray-800 dark:text-white">
                                    {{ $teacher->first_name }} {{ $teacher->last_name }}
                                </h2>
                                <p class="mb-4 text-gray-500 dark:text-gray-400">{{ $teacher->email }}</p>

                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</p>
                                        <p class="text-gray-800 dark:text-white">{{ $teacher->phone ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Role</p>
                                        <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                            {{ ucfirst($teacher->role) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Joined</p>
                                        <p class="text-gray-800 dark:text-white">{{ $teacher->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($teacher->address || $teacher->city || $teacher->state || $teacher->country)
                            <div class="mt-8 border-t border-gray-200 pt-6 dark:border-gray-800">
                                <h4 class="mb-4 text-lg font-semibold text-gray-800 dark:text-white">Address Information</h4>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</p>
                                        <p class="text-gray-800 dark:text-white">{{ $teacher->address ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">City</p>
                                        <p class="text-gray-800 dark:text-white">{{ $teacher->city ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">State</p>
                                        <p class="text-gray-800 dark:text-white">{{ $teacher->state ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">ZIP / Country</p>
                                        <p class="text-gray-800 dark:text-white">{{ $teacher->zip ?? '' }} {{ $teacher->country ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
