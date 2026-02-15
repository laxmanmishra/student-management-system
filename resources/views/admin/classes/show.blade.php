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

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <div class="lg:col-span-2">
                        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                            <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4 dark:border-gray-800 sm:px-6">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Class Details</h3>
                                <a href="{{ route('admin.classes.edit', $class) }}"
                                   class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                            </div>

                            <div class="p-5 sm:p-6">
                                <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Class Name</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $class->name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Numeric Name</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $class->numeric_name ?? '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Class Teacher</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                            {{ $class->classTeacher ? $class->classTeacher->first_name . ' ' . $class->classTeacher->last_name : 'Not Assigned' }}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                        <dd class="mt-1">
                                            @if($class->is_active)
                                                <span class="inline-flex rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900/30 dark:text-green-400">Active</span>
                                            @else
                                                <span class="inline-flex rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900/30 dark:text-red-400">Inactive</span>
                                            @endif
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $class->description ?? 'No description' }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <div class="mt-6 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                            <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-800 sm:px-6">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Sections ({{ $class->sections->count() }})</h3>
                            </div>
                            <div class="p-5 sm:p-6">
                                @if($class->sections->count() > 0)
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($class->sections as $section)
                                            <span class="inline-flex items-center rounded-lg bg-gray-100 px-3 py-1.5 text-sm font-medium text-gray-800 dark:bg-gray-800 dark:text-gray-200">
                                                {{ $section->name }}
                                                @if($section->capacity)
                                                    <span class="ml-1 text-gray-500">({{ $section->capacity }})</span>
                                                @endif
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No sections added yet.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                            <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-800 sm:px-6">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Subjects ({{ $class->subjects->count() }})</h3>
                            </div>
                            <div class="p-5 sm:p-6">
                                @if($class->subjects->count() > 0)
                                    <ul class="space-y-2">
                                        @foreach($class->subjects as $subject)
                                            <li class="flex items-center justify-between rounded-lg bg-gray-50 px-3 py-2 dark:bg-gray-800">
                                                <span class="text-sm font-medium text-gray-800 dark:text-white">{{ $subject->name }}</span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $subject->code }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No subjects assigned yet.</p>
                                @endif
                            </div>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('admin.classes.index') }}"
                               class="flex w-full items-center justify-center gap-2 rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Back to Classes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
