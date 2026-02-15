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
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Edit Fee Record</h3>
                    </div>

                    <form method="POST" action="{{ route('admin.fees.update', $fee) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="user_id" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Student <span class="text-red-500">*</span></label>
                                <select name="user_id" id="user_id" required class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('user_id') border-red-500 @enderror">
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}" {{ old('user_id', $fee->user_id) == $student->id ? 'selected' : '' }}>{{ $student->name }} ({{ $student->email }})</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="school_class_id" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Class <span class="text-red-500">*</span></label>
                                <select name="school_class_id" id="school_class_id" required class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('school_class_id') border-red-500 @enderror">
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}" {{ old('school_class_id', $fee->school_class_id) == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                    @endforeach
                                </select>
                                @error('school_class_id')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="fee_type" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Fee Type <span class="text-red-500">*</span></label>
                                <select name="fee_type" id="fee_type" required class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('fee_type') border-red-500 @enderror">
                                    <option value="tuition" {{ old('fee_type', $fee->fee_type) == 'tuition' ? 'selected' : '' }}>Tuition Fee</option>
                                    <option value="admission" {{ old('fee_type', $fee->fee_type) == 'admission' ? 'selected' : '' }}>Admission Fee</option>
                                    <option value="exam" {{ old('fee_type', $fee->fee_type) == 'exam' ? 'selected' : '' }}>Exam Fee</option>
                                    <option value="library" {{ old('fee_type', $fee->fee_type) == 'library' ? 'selected' : '' }}>Library Fee</option>
                                    <option value="transport" {{ old('fee_type', $fee->fee_type) == 'transport' ? 'selected' : '' }}>Transport Fee</option>
                                    <option value="lab" {{ old('fee_type', $fee->fee_type) == 'lab' ? 'selected' : '' }}>Lab Fee</option>
                                    <option value="sports" {{ old('fee_type', $fee->fee_type) == 'sports' ? 'selected' : '' }}>Sports Fee</option>
                                    <option value="other" {{ old('fee_type', $fee->fee_type) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('fee_type')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="amount" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Amount (₹) <span class="text-red-500">*</span></label>
                                <input type="number" name="amount" id="amount" value="{{ old('amount', $fee->amount) }}" required min="0" step="0.01" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('amount') border-red-500 @enderror">
                                @error('amount')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="discount" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Discount (₹)</label>
                                <input type="number" name="discount" id="discount" value="{{ old('discount', $fee->discount) }}" min="0" step="0.01" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('discount') border-red-500 @enderror">
                                @error('discount')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="due_date" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Due Date <span class="text-red-500">*</span></label>
                                <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $fee->due_date->format('Y-m-d')) }}" required class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('due_date') border-red-500 @enderror">
                                @error('due_date')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="remarks" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Remarks</label>
                                <textarea name="remarks" id="remarks" rows="3" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('remarks') border-red-500 @enderror">{{ old('remarks', $fee->remarks) }}</textarea>
                                @error('remarks')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600">Update Fee Record</button>
                            <a href="{{ route('admin.fees.index') }}" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
