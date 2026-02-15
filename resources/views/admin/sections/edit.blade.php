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

                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-800 sm:px-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Edit Section</h3>
                    </div>

                    <form action="{{ route('admin.sections.update', $section) }}" method="POST" class="p-5 sm:p-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="name" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Section Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name', $section->name) }}"
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('name') border-red-500 @enderror"
                                       required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="school_class_id" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Class <span class="text-red-500">*</span>
                                </label>
                                <select name="school_class_id" id="school_class_id"
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('school_class_id') border-red-500 @enderror"
                                        required>
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ old('school_class_id', $section->school_class_id) == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('school_class_id')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="capacity" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Capacity
                                </label>
                                <input type="number" name="capacity" id="capacity" value="{{ old('capacity', $section->capacity) }}" min="1"
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Status
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $section->is_active) ? 'checked' : '' }}
                                           class="h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Active</span>
                                </label>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-3">
                            <a href="{{ route('admin.sections.index') }}"
                               class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
                                Update Section
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
