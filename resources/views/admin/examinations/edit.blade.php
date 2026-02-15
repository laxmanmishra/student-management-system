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
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Edit Examination</h3>
                    </div>

                    <form method="POST" action="{{ route('admin.examinations.update', $examination) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="name" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Examination Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name', $examination->name) }}" required class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="exam_type" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Exam Type <span class="text-red-500">*</span></label>
                                <select name="exam_type" id="exam_type" required class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('exam_type') border-red-500 @enderror">
                                    <option value="term" {{ old('exam_type', $examination->exam_type) == 'term' ? 'selected' : '' }}>Term</option>
                                    <option value="midterm" {{ old('exam_type', $examination->exam_type) == 'midterm' ? 'selected' : '' }}>Midterm</option>
                                    <option value="final" {{ old('exam_type', $examination->exam_type) == 'final' ? 'selected' : '' }}>Final</option>
                                    <option value="unit" {{ old('exam_type', $examination->exam_type) == 'unit' ? 'selected' : '' }}>Unit Test</option>
                                    <option value="quarterly" {{ old('exam_type', $examination->exam_type) == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                </select>
                                @error('exam_type')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="school_class_id" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Class <span class="text-red-500">*</span></label>
                                <select name="school_class_id" id="school_class_id" required class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('school_class_id') border-red-500 @enderror">
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}" {{ old('school_class_id', $examination->school_class_id) == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                    @endforeach
                                </select>
                                @error('school_class_id')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="subject_id" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Subject <span class="text-red-500">*</span></label>
                                <select name="subject_id" id="subject_id" required class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('subject_id') border-red-500 @enderror">
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ old('subject_id', $examination->subject_id) == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="exam_date" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Exam Date <span class="text-red-500">*</span></label>
                                <input type="date" name="exam_date" id="exam_date" value="{{ old('exam_date', $examination->exam_date->format('Y-m-d')) }}" required class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('exam_date') border-red-500 @enderror">
                                @error('exam_date')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="start_time" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Start Time <span class="text-red-500">*</span></label>
                                    <input type="time" name="start_time" id="start_time" value="{{ old('start_time', $examination->start_time) }}" required class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('start_time') border-red-500 @enderror">
                                    @error('start_time')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="end_time" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">End Time <span class="text-red-500">*</span></label>
                                    <input type="time" name="end_time" id="end_time" value="{{ old('end_time', $examination->end_time) }}" required class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('end_time') border-red-500 @enderror">
                                    @error('end_time')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="total_marks" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Total Marks <span class="text-red-500">*</span></label>
                                <input type="number" name="total_marks" id="total_marks" value="{{ old('total_marks', $examination->total_marks) }}" required min="1" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('total_marks') border-red-500 @enderror">
                                @error('total_marks')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="passing_marks" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Passing Marks <span class="text-red-500">*</span></label>
                                <input type="number" name="passing_marks" id="passing_marks" value="{{ old('passing_marks', $examination->passing_marks) }}" required min="0" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('passing_marks') border-red-500 @enderror">
                                @error('passing_marks')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="description" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <textarea name="description" id="description" rows="3" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('description') border-red-500 @enderror">{{ old('description', $examination->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $examination->is_active) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                                <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">Active</label>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600">Update Examination</button>
                            <a href="{{ route('admin.examinations.index') }}" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
