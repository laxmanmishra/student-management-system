@extends('layouts.app')

@section('content')
<div class="flex h-screen overflow-hidden">
    @include('partials.sidebar')
    <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
        @include('partials.overlay')
        @include('partials.header')
        <main>
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                <div x-data="{ pageName: `Send Notification`}">@include('partials.breadcrumb')</div>

                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5 lg:p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Send Notification</h3>
                    </div>

                    <form method="POST" action="{{ route('teacher.notifications.store') }}" x-data="{ audience: '{{ old('target_audience', 'students') }}' }">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                            <div class="md:col-span-2">
                                <label for="title" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Title <span class="text-red-500">*</span></label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                       class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('title') border-red-500 @enderror"
                                       placeholder="Notification title">
                                @error('title')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="type" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Type <span class="text-red-500">*</span></label>
                                <select name="type" id="type" required class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('type') border-red-500 @enderror">
                                    <option value="info" {{ old('type', 'info') == 'info' ? 'selected' : '' }}>Info</option>
                                    <option value="warning" {{ old('type') == 'warning' ? 'selected' : '' }}>Warning</option>
                                    <option value="success" {{ old('type') == 'success' ? 'selected' : '' }}>Success</option>
                                    <option value="danger" {{ old('type') == 'danger' ? 'selected' : '' }}>Danger</option>
                                </select>
                                @error('type')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="target_audience" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Target Audience <span class="text-red-500">*</span></label>
                                <select name="target_audience" id="target_audience" x-model="audience" required
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('target_audience') border-red-500 @enderror">
                                    <option value="all">All Users</option>
                                    <option value="students">Students</option>
                                    <option value="specific">Specific User</option>
                                </select>
                                @error('target_audience')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                            </div>

                            <div x-show="audience === 'specific'" x-cloak>
                                <label for="target_user_id" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Specific Student</label>
                                <select name="target_user_id" id="target_user_id"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                    <option value="">Select Student</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}" {{ old('target_user_id') == $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
                                    @endforeach
                                </select>
                                @error('target_user_id')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                            </div>

                            @if($classes->isNotEmpty())
                            <div>
                                <label for="school_class_id" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Class (optional)</label>
                                <select name="school_class_id" id="school_class_id"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                    <option value="">No specific class</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}" {{ old('school_class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <div class="md:col-span-2">
                                <label for="message" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Message <span class="text-red-500">*</span></label>
                                <textarea name="message" id="message" rows="5" required
                                          class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('message') border-red-500 @enderror"
                                          placeholder="Write your notification message here...">{{ old('message') }}</textarea>
                                @error('message')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600">Send Notification</button>
                            <a href="{{ route('teacher.notifications.index') }}" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
