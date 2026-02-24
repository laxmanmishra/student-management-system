@extends('layouts.app')

@section('content')
<div class="flex h-screen overflow-hidden">
    @include('partials.sidebar')
    <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
        @include('partials.overlay')
        @include('partials.header')
        <main>
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                <div x-data="{ pageName: `Notification Details`}">@include('partials.breadcrumb')</div>

                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5 lg:p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Notification Details</h3>
                        <a href="{{ route('teacher.notifications.index') }}" class="text-sm text-brand-500 hover:text-brand-600">← Back to List</a>
                    </div>

                    @php
                        $typeColors = [
                            'info'    => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400',
                            'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400',
                            'success' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400',
                            'danger'  => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400',
                        ];
                    @endphp

                    <div class="mb-6 rounded-xl border border-gray-100 bg-gray-50 p-4 dark:border-gray-800 dark:bg-gray-900/50">
                        <div class="flex items-start gap-3">
                            <span class="shrink-0 inline-flex rounded-full px-2 py-1 text-xs font-semibold {{ $typeColors[$notification->type] ?? '' }}">
                                {{ ucfirst($notification->type) }}
                            </span>
                            <div class="flex-1">
                                <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">{{ $notification->title }}</h4>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $notification->message }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-gray-500 dark:text-gray-400">Audience</span>
                            <p class="mt-1 text-gray-900 dark:text-white capitalize">{{ $notification->target_audience }}</p>
                        </div>
                        @if ($notification->targetUser)
                        <div>
                            <span class="font-medium text-gray-500 dark:text-gray-400">Target User</span>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $notification->targetUser->name }}</p>
                        </div>
                        @endif
                        @if ($notification->schoolClass)
                        <div>
                            <span class="font-medium text-gray-500 dark:text-gray-400">Class</span>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $notification->schoolClass->name }}</p>
                        </div>
                        @endif
                        <div>
                            <span class="font-medium text-gray-500 dark:text-gray-400">Published At</span>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $notification->published_at?->format('F d, Y H:i A') ?? 'Not published' }}</p>
                        </div>
                        @if ($notification->expires_at)
                        <div>
                            <span class="font-medium text-gray-500 dark:text-gray-400">Expires At</span>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $notification->expires_at->format('F d, Y H:i A') }}</p>
                        </div>
                        @endif
                        <div>
                            <span class="font-medium text-gray-500 dark:text-gray-400">Created By</span>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $notification->createdBy->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
