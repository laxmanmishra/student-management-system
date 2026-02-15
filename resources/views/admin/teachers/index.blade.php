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

                @if(session('success'))
                    <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex items-center justify-between px-5 py-4 sm:px-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Teachers</h3>
                        <a href="{{ route('admin.teachers.create') }}"
                           class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add Teacher
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-t border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-gray-900/50">
                                    <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Name</th>
                                    <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Email</th>
                                    <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Phone</th>
                                    <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Created</th>
                                    <th class="px-5 py-3 text-right text-sm font-medium text-gray-500 dark:text-gray-400">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                @forelse($teachers as $teacher)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50">
                                        <td class="px-5 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="h-10 w-10 overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                                                    @if($teacher->avatar)
                                                        <img src="{{ Storage::url($teacher->avatar) }}" alt="{{ $teacher->name }}" class="h-full w-full object-cover">
                                                    @else
                                                        <div class="flex h-full w-full items-center justify-center text-sm font-medium text-gray-600 dark:text-gray-300">
                                                            {{ strtoupper(substr($teacher->first_name ?? $teacher->name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-800 dark:text-white">{{ $teacher->first_name }} {{ $teacher->last_name }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 text-gray-600 dark:text-gray-400">{{ $teacher->email }}</td>
                                        <td class="px-5 py-4 text-gray-600 dark:text-gray-400">{{ $teacher->phone ?? '-' }}</td>
                                        <td class="px-5 py-4 text-gray-600 dark:text-gray-400">{{ $teacher->created_at->format('M d, Y') }}</td>
                                        <td class="px-5 py-4">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.teachers.show', $teacher) }}"
                                                   class="rounded p-1.5 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                                                   title="View">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('admin.teachers.edit', $teacher) }}"
                                                   class="rounded p-1.5 text-gray-500 hover:bg-gray-100 hover:text-blue-600 dark:hover:bg-gray-800 dark:hover:text-blue-400"
                                                   title="Edit">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.teachers.reset-password', $teacher) }}" method="POST" class="inline"
                                                      onsubmit="return confirm('Reset password for this teacher?')">
                                                    @csrf
                                                    <button type="submit"
                                                            class="rounded p-1.5 text-gray-500 hover:bg-gray-100 hover:text-yellow-600 dark:hover:bg-gray-800 dark:hover:text-yellow-400"
                                                            title="Reset Password">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" class="inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this teacher?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="rounded p-1.5 text-gray-500 hover:bg-gray-100 hover:text-red-600 dark:hover:bg-gray-800 dark:hover:text-red-400"
                                                            title="Delete">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-8 text-center text-gray-500 dark:text-gray-400">
                                            No teachers found. <a href="{{ route('admin.teachers.create') }}" class="text-brand-500 hover:underline">Add one now</a>.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($teachers->hasPages())
                        <div class="border-t border-gray-200 px-5 py-4 dark:border-gray-800">
                            {{ $teachers->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
