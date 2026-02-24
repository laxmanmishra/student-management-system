@extends('layouts.app')

@section('content')
<div class="flex h-screen overflow-hidden">
    @include('partials.sidebar')
    <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
        @include('partials.overlay')
        @include('partials.header')
        <main>
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                <div x-data="{ pageName: `Notification`}">@include('partials.breadcrumb')</div>

                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5 lg:p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Notification</h3>
                        <a href="{{ route('student.notifications.index') }}" class="text-sm text-brand-500 hover:text-brand-600">← Back to Inbox</a>
                    </div>

                    @php
                        $typeColors = [
                            'info'    => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400',
                            'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400',
                            'success' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400',
                            'danger'  => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400',
                        ];
                        $bgColors = [
                            'info'    => 'bg-blue-50 border-blue-100 dark:bg-blue-900/10 dark:border-blue-900',
                            'warning' => 'bg-yellow-50 border-yellow-100 dark:bg-yellow-900/10 dark:border-yellow-900',
                            'success' => 'bg-green-50 border-green-100 dark:bg-green-900/10 dark:border-green-900',
                            'danger'  => 'bg-red-50 border-red-100 dark:bg-red-900/10 dark:border-red-900',
                        ];
                    @endphp

                    <div class="rounded-xl border p-5 {{ $bgColors[$notification->type] ?? 'bg-gray-50 border-gray-100 dark:bg-gray-800 dark:border-gray-700' }}">
                        <div class="flex items-start gap-3 mb-4">
                            <span class="shrink-0 inline-flex rounded-full px-2 py-1 text-xs font-semibold {{ $typeColors[$notification->type] ?? '' }}">
                                {{ ucfirst($notification->type) }}
                            </span>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90">{{ $notification->title }}</h4>
                        </div>
                        <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed">{{ $notification->message }}</p>
                    </div>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-gray-500 dark:text-gray-400">From</span>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $notification->createdBy->name ?? 'School Administration' }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-500 dark:text-gray-400">Published</span>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $notification->published_at?->format('F d, Y H:i A') ?? $notification->created_at->format('F d, Y H:i A') }}</p>
                        </div>
                        @if($notification->expires_at)
                        <div>
                            <span class="font-medium text-gray-500 dark:text-gray-400">Expires</span>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $notification->expires_at->format('F d, Y H:i A') }}</p>
                        </div>
                        @endif
                        <div>
                            <span class="font-medium text-gray-500 dark:text-gray-400">Audience</span>
                            <p class="mt-1 text-gray-900 dark:text-white capitalize">{{ $notification->target_audience }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
