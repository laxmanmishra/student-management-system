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

                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5 lg:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Fee Records</h3>
                        <a href="{{ route('admin.fees.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            Add Fee
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-green-900/50 dark:text-green-400">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="GET" action="{{ route('admin.fees.index') }}" class="mb-6 grid grid-cols-1 md:grid-cols-5 gap-4">
                        <select name="class_id" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="">All Classes</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                            @endforeach
                        </select>
                        <select name="fee_type" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="">All Types</option>
                            <option value="tuition" {{ request('fee_type') == 'tuition' ? 'selected' : '' }}>Tuition</option>
                            <option value="admission" {{ request('fee_type') == 'admission' ? 'selected' : '' }}>Admission</option>
                            <option value="exam" {{ request('fee_type') == 'exam' ? 'selected' : '' }}>Exam</option>
                            <option value="library" {{ request('fee_type') == 'library' ? 'selected' : '' }}>Library</option>
                            <option value="transport" {{ request('fee_type') == 'transport' ? 'selected' : '' }}>Transport</option>
                            <option value="lab" {{ request('fee_type') == 'lab' ? 'selected' : '' }}>Lab</option>
                            <option value="sports" {{ request('fee_type') == 'sports' ? 'selected' : '' }}>Sports</option>
                            <option value="other" {{ request('fee_type') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        <select name="status" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partial</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                        </select>
                        <select name="student_id" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="">All Students</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-900 dark:bg-white/10 dark:hover:bg-white/20">Filter</button>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Student</th>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Class</th>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Type</th>
                                    <th class="px-4 py-3.5 text-right text-sm font-semibold text-gray-900 dark:text-white">Amount</th>
                                    <th class="px-4 py-3.5 text-right text-sm font-semibold text-gray-900 dark:text-white">Paid</th>
                                    <th class="px-4 py-3.5 text-right text-sm font-semibold text-gray-900 dark:text-white">Balance</th>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Due Date</th>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Status</th>
                                    <th class="px-4 py-3.5 text-right text-sm font-semibold text-gray-900 dark:text-white">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($fees as $fee)
                                    <tr>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $fee->student->name ?? 'N/A' }}</td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $fee->schoolClass->name ?? 'N/A' }}</td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm">
                                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-400">
                                                {{ ucfirst($fee->fee_type) }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm text-right text-gray-700 dark:text-gray-300">₹{{ number_format($fee->amount, 2) }}</td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm text-right text-green-600">₹{{ number_format($fee->paid_amount, 2) }}</td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm text-right font-medium {{ $fee->balance > 0 ? 'text-red-600' : 'text-green-600' }}">₹{{ number_format($fee->balance, 2) }}</td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $fee->due_date->format('M d, Y') }}</td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400',
                                                    'partial' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400',
                                                    'paid' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400',
                                                    'overdue' => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400',
                                                ];
                                            @endphp
                                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold {{ $statusColors[$fee->status] ?? '' }}">
                                                {{ ucfirst($fee->status) }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4 text-right text-sm">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.fees.show', $fee) }}" class="text-gray-500 hover:text-brand-500 dark:text-gray-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                </a>
                                                <a href="{{ route('admin.fees.edit', $fee) }}" class="text-gray-500 hover:text-brand-500 dark:text-gray-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                                </a>
                                                <form action="{{ route('admin.fees.destroy', $fee) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-gray-500 hover:text-red-500 dark:text-gray-400">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">No fee records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $fees->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
