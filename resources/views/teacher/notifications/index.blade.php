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
                        <a href="{{ route('teacher.notifications.create') }}"
                           class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Send Notification
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-green-900/50 dark:text-green-400">{{ session('success') }}</div>
                    @endif

                    <form method="GET" action="{{ route('teacher.notifications.index') }}" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <select name="type" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="">All Types</option>
                            <option value="info" {{ request('type') == 'info' ? 'selected' : '' }}>Info</option>
                            <option value="warning" {{ request('type') == 'warning' ? 'selected' : '' }}>Warning</option>
                            <option value="success" {{ request('type') == 'success' ? 'selected' : '' }}>Success</option>
                            <option value="danger" {{ request('type') == 'danger' ? 'selected' : '' }}>Danger</option>
                        </select>
                        <button type="submit" class="rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-900 dark:bg-white/10 dark:hover:bg-white/20">Filter</button>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Title</th>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Type</th>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Audience</th>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Published</th>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">By</th>
                                    <th class="px-4 py-3.5 text-right text-sm font-semibold text-gray-900 dark:text-white">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($notifications as $notification)
                                    @php
                                        $typeColors = [
                                            'info'    => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400',
                                            'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400',
                                            'success' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400',
                                            'danger'  => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400',
                                        ];
                                    @endphp
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/30">
                                        <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-300">
                                            <div class="max-w-xs truncate font-medium">{{ $notification->title }}</div>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm">
                                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold {{ $typeColors[$notification->type] ?? '' }}">
                                                {{ ucfirst($notification->type) }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm">
                                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-400">
                                                {{ ucfirst($notification->target_audience) }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $notification->published_at?->format('M d, Y H:i') ?? '—' }}</td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $notification->createdBy->name ?? 'N/A' }}</td>
                                        <td class="whitespace-nowrap px-4 py-4 text-right text-sm">
                                            <a href="{{ route('teacher.notifications.show', $notification) }}"
                                               class="rounded p-1.5 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-800" title="View">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-10 text-center text-sm text-gray-500 dark:text-gray-400">No notifications found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">{{ $notifications->withQueryString()->links() }}</div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
