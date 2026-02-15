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
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Edit Student</h3>
                    </div>

                    <form action="{{ route('admin.students.update', $student) }}" method="POST" enctype="multipart/form-data" class="p-5 sm:p-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="first_name" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    First Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $student->first_name) }}"
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('first_name') border-red-500 @enderror"
                                       required>
                                @error('first_name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="last_name" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Last Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $student->last_name) }}"
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('last_name') border-red-500 @enderror"
                                       required>
                                @error('last_name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email', $student->email) }}"
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('email') border-red-500 @enderror"
                                       required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Phone
                                </label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $student->phone) }}"
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="password" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Password <span class="text-xs text-gray-500">(leave blank to keep current)</span>
                                </label>
                                <input type="password" name="password" id="password"
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('password') border-red-500 @enderror">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Confirm Password
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div class="md:col-span-2">
                                <label for="address" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Address
                                </label>
                                <input type="text" name="address" id="address" value="{{ old('address', $student->address) }}"
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="city" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    City
                                </label>
                                <input type="text" name="city" id="city" value="{{ old('city', $student->city) }}"
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="state" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    State
                                </label>
                                <input type="text" name="state" id="state" value="{{ old('state', $student->state) }}"
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="zip" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    ZIP Code
                                </label>
                                <input type="text" name="zip" id="zip" value="{{ old('zip', $student->zip) }}"
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="country" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Country
                                </label>
                                <input type="text" name="country" id="country" value="{{ old('country', $student->country) }}"
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div class="md:col-span-2">
                                <label for="avatar" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Avatar
                                </label>
                                @if($student->avatar)
                                    <div class="mb-3 flex items-center gap-3">
                                        <img src="{{ Storage::url($student->avatar) }}" alt="Current avatar" class="h-16 w-16 rounded-full object-cover">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Current avatar</span>
                                    </div>
                                @endif
                                <input type="file" name="avatar" id="avatar" accept="image/*"
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-800 file:mr-4 file:rounded file:border-0 file:bg-brand-500 file:px-4 file:py-2 file:text-sm file:text-white hover:file:bg-brand-600 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                @error('avatar')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-3">
                            <a href="{{ route('admin.students.index') }}"
                               class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
                                Update Student
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
