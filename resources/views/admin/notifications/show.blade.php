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

                @if (session('success'))
                    <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-green-900/50 dark:text-green-400">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5 lg:p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Notification Details</h3>
                        <a href="{{ route('admin.notifications.index') }}" class="text-sm text-brand-500 hover:text-brand-600">← Back to List</a>
                    </div>

                    <div class="mb-6">
                        <div class="flex items-center gap-3 mb-4">
                            @php
                                $typeColors = [
                                    'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400',
                                    'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400',
                                    'success' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400',
                                    'danger' => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400',
                                ];
                            @endphp
                            <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $typeColors[$notification->type] ?? '' }}">
                                {{ ucfirst($notification->type) }}
                            </span>
                            @if ($notification->is_active)
                                <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400">Active</span>
                            @else
                                <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold bg-gray-100 text-gray-800 dark:bg-gray-900/50 dark:text-gray-400">Inactive</span>
                            @endif
                        </div>

                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{ $notification->title }}</h2>

                        <div class="prose prose-sm max-w-none dark:prose-invert mb-6">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $notification->message }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Target Audience</span>
                            <p class="mt-1 text-gray-900 dark:text-white">
                                <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-400">
                                    {{ ucfirst($notification->target_audience) }}
                                </span>
                            </p>
                        </div>

                        @if ($notification->targetUser)
                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Specific User</span>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $notification->targetUser->name }}</p>
                        </div>
                        @endif

                        @if ($notification->schoolClass)
                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Class</span>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $notification->schoolClass->name }}</p>
                        </div>
                        @endif

                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Published At</span>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $notification->published_at?->format('F d, Y H:i') ?? 'Not set' }}</p>
                        </div>

                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Expires At</span>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $notification->expires_at?->format('F d, Y H:i') ?? 'Never' }}</p>
                        </div>

                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Created By</span>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $notification->createdBy->name ?? 'N/A' }}</p>
                        </div>

                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At</span>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $notification->created_at->format('F d, Y H:i') }}</p>
                        </div>

                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</span>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $notification->updated_at->format('F d, Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <a href="{{ route('admin.notifications.edit', $notification) }}" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600">Edit</a>
                        <form action="{{ route('admin.notifications.destroy', $notification) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg border border-red-300 bg-white px-5 py-2.5 text-sm font-medium text-red-700 transition hover:bg-red-50 dark:border-red-600 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-red-900/20">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
