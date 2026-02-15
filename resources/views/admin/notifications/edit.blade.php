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
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Edit Notification</h3>
                    </div>

                    <form method="POST" action="{{ route('admin.notifications.update', $notification) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="md:col-span-2">
                                <label for="title" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Title <span class="text-red-500">*</span></label>
                                <input type="text" name="title" id="title" value="{{ old('title', $notification->title) }}" required class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('title') border-red-500 @enderror">
                                @error('title')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="message" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Message <span class="text-red-500">*</span></label>
                                <textarea name="message" id="message" rows="4" required class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('message') border-red-500 @enderror">{{ old('message', $notification->message) }}</textarea>
                                @error('message')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="type" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Type <span class="text-red-500">*</span></label>
                                <select name="type" id="type" required class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('type') border-red-500 @enderror">
                                    <option value="info" {{ old('type', $notification->type) == 'info' ? 'selected' : '' }}>Info</option>
                                    <option value="warning" {{ old('type', $notification->type) == 'warning' ? 'selected' : '' }}>Warning</option>
                                    <option value="success" {{ old('type', $notification->type) == 'success' ? 'selected' : '' }}>Success</option>
                                    <option value="danger" {{ old('type', $notification->type) == 'danger' ? 'selected' : '' }}>Danger</option>
                                </select>
                                @error('type')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="target_audience" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Target Audience <span class="text-red-500">*</span></label>
                                <select name="target_audience" id="target_audience" required class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('target_audience') border-red-500 @enderror">
                                    <option value="all" {{ old('target_audience', $notification->target_audience) == 'all' ? 'selected' : '' }}>All Users</option>
                                    <option value="students" {{ old('target_audience', $notification->target_audience) == 'students' ? 'selected' : '' }}>Students Only</option>
                                    <option value="teachers" {{ old('target_audience', $notification->target_audience) == 'teachers' ? 'selected' : '' }}>Teachers Only</option>
                                    <option value="admins" {{ old('target_audience', $notification->target_audience) == 'admins' ? 'selected' : '' }}>Admins Only</option>
                                    <option value="specific" {{ old('target_audience', $notification->target_audience) == 'specific' ? 'selected' : '' }}>Specific User</option>
                                </select>
                                @error('target_audience')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="target_user_id" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Specific User (Optional)</label>
                                <select name="target_user_id" id="target_user_id" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('target_user_id') border-red-500 @enderror">
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ old('target_user_id', $notification->target_user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->role }})</option>
                                    @endforeach
                                </select>
                                @error('target_user_id')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="school_class_id" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Class (Optional)</label>
                                <select name="school_class_id" id="school_class_id" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('school_class_id') border-red-500 @enderror">
                                    <option value="">All Classes</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}" {{ old('school_class_id', $notification->school_class_id) == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                    @endforeach
                                </select>
                                @error('school_class_id')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="published_at" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Publish Date</label>
                                <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', $notification->published_at?->format('Y-m-d\TH:i')) }}" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('published_at') border-red-500 @enderror">
                                @error('published_at')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="expires_at" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Expiry Date</label>
                                <input type="datetime-local" name="expires_at" id="expires_at" value="{{ old('expires_at', $notification->expires_at?->format('Y-m-d\TH:i')) }}" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('expires_at') border-red-500 @enderror">
                                @error('expires_at')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $notification->is_active) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                                <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">Active</label>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600">Update Notification</button>
                            <a href="{{ route('admin.notifications.index') }}" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
