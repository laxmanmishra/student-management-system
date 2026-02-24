@extends('layouts.app')

@section('content')
<div class="flex h-screen overflow-hidden">
    @include('partials.sidebar')
    <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
        @include('partials.overlay')
        @include('partials.header')
        <main>
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                <div x-data="{ pageName: `Notifications`}">@include('partials.breadcrumb')</div>

                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5 lg:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Notifications</h3>
                    </div>

                    <form method="GET" action="{{ route('student.notifications.index') }}" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <select name="type" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="">All Types</option>
                            <option value="info" {{ request('type') == 'info' ? 'selected' : '' }}>Info</option>
                            <option value="warning" {{ request('type') == 'warning' ? 'selected' : '' }}>Warning</option>
                            <option value="success" {{ request('type') == 'success' ? 'selected' : '' }}>Success</option>
                            <option value="danger" {{ request('type') == 'danger' ? 'selected' : '' }}>Danger</option>
                        </select>
                        <button type="submit" class="md:col-start-3 rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-900 dark:bg-white/10 dark:hover:bg-white/20">Filter</button>
                    </form>

                    <div class="space-y-3">
                        @forelse ($notifications as $notification)
                            @php
                                $typeColors = [
                                    'info'    => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400',
                                    'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400',
                                    'success' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400',
                                    'danger'  => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400',
                                ];
                                $borderColors = [
                                    'info'    => 'border-blue-200 dark:border-blue-800',
                                    'warning' => 'border-yellow-200 dark:border-yellow-800',
                                    'success' => 'border-green-200 dark:border-green-800',
                                    'danger'  => 'border-red-200 dark:border-red-800',
                                ];
                            @endphp
                            <a href="{{ route('student.notifications.show', $notification) }}"
                               class="flex items-start gap-4 rounded-xl border p-4 transition hover:bg-gray-50 dark:hover:bg-gray-900/30 {{ $borderColors[$notification->type] ?? 'border-gray-200 dark:border-gray-800' }}">
                                <span class="shrink-0 mt-0.5 inline-flex rounded-full px-2 py-1 text-xs font-semibold {{ $typeColors[$notification->type] ?? '' }}">
                                    {{ ucfirst($notification->type) }}
                                </span>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-800 dark:text-white/90">{{ $notification->title }}</p>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ $notification->message }}</p>
                                    <div class="mt-2 flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400">
                                        <span>{{ $notification->createdBy->name ?? 'School' }}</span>
                                        <span>·</span>
                                        <span>{{ $notification->published_at?->diffForHumans() ?? $notification->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <svg class="shrink-0 text-gray-400" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </a>
                        @empty
                            <div class="py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                No notifications at the moment.
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">{{ $notifications->withQueryString()->links() }}</div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
