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
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Edit Attendance</h3>
                    </div>

                    <div class="mb-6 rounded-lg bg-gray-50 p-4 dark:bg-gray-800">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                            <div>
                                <span class="font-medium text-gray-500 dark:text-gray-400">Student:</span>
                                <p class="text-gray-900 dark:text-white">{{ $attendance->student->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-500 dark:text-gray-400">Class:</span>
                                <p class="text-gray-900 dark:text-white">{{ $attendance->schoolClass->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-500 dark:text-gray-400">Section:</span>
                                <p class="text-gray-900 dark:text-white">{{ $attendance->section->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-500 dark:text-gray-400">Date:</span>
                                <p class="text-gray-900 dark:text-white">{{ $attendance->date->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.attendance.update', $attendance) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="status" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Status <span class="text-red-500">*</span></label>
                                <select name="status" id="status" required class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('status') border-red-500 @enderror">
                                    <option value="present" {{ old('status', $attendance->status) == 'present' ? 'selected' : '' }}>Present</option>
                                    <option value="absent" {{ old('status', $attendance->status) == 'absent' ? 'selected' : '' }}>Absent</option>
                                    <option value="late" {{ old('status', $attendance->status) == 'late' ? 'selected' : '' }}>Late</option>
                                    <option value="excused" {{ old('status', $attendance->status) == 'excused' ? 'selected' : '' }}>Excused</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="remarks" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Remarks</label>
                                <input type="text" name="remarks" id="remarks" value="{{ old('remarks', $attendance->remarks) }}" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('remarks') border-red-500 @enderror">
                                @error('remarks')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600">Update Attendance</button>
                            <a href="{{ route('admin.attendance.index') }}" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
