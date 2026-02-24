@extends('layouts.app')

@section('content')
<div class="flex h-screen overflow-hidden">
    @include('partials.sidebar')

    <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
        @include('partials.overlay')
        @include('partials.header')

        <main>
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                <div x-data="{ pageName: `Mark Attendance`}">
                    @include('partials.breadcrumb')
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5 lg:p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Mark Attendance</h3>
                    </div>

                    <form method="POST" action="{{ route('teacher.attendance.store') }}" id="attendanceForm">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <label for="school_class_id" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Class <span class="text-red-500">*</span></label>
                                <select name="school_class_id" id="school_class_id" required
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('school_class_id') border-red-500 @enderror">
                                    <option value="">Select Class</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}" {{ old('school_class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                    @endforeach
                                </select>
                                @error('school_class_id')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="section_id" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Section <span class="text-red-500">*</span></label>
                                <select name="section_id" id="section_id" required
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('section_id') border-red-500 @enderror">
                                    <option value="">Select Section</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>{{ $section->name }} ({{ $section->schoolClass->name ?? 'N/A' }})</option>
                                    @endforeach
                                </select>
                                @error('section_id')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="date" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Date <span class="text-red-500">*</span></label>
                                <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" required
                                       class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('date') border-red-500 @enderror">
                                @error('date')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <button type="button" id="loadStudents"
                                    class="rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-900 dark:bg-white/10 dark:hover:bg-white/20">
                                Load Students
                            </button>
                        </div>

                        <div id="studentsList" class="hidden">
                            <div class="mb-4 flex items-center gap-3">
                                <button type="button" id="markAllPresent"
                                        class="rounded-lg border border-green-300 bg-green-50 px-3 py-1.5 text-xs font-medium text-green-700 transition hover:bg-green-100 dark:border-green-800 dark:bg-green-900/20 dark:text-green-400">
                                    Mark All Present
                                </button>
                                <button type="button" id="markAllAbsent"
                                        class="rounded-lg border border-red-300 bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 transition hover:bg-red-100 dark:border-red-800 dark:bg-red-900/20 dark:text-red-400">
                                    Mark All Absent
                                </button>
                                <span id="studentCount" class="text-sm text-gray-500 dark:text-gray-400"></span>
                            </div>

                            <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                                        <tr>
                                            <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">#</th>
                                            <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Student Name</th>
                                            <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Status</th>
                                            <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody id="studentsBody" class="divide-y divide-gray-200 dark:divide-gray-700">
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-6 flex items-center gap-4">
                                <button type="submit"
                                        class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600">
                                    Save Attendance
                                </button>
                                <a href="{{ route('teacher.attendance.index') }}"
                                   class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
document.getElementById('loadStudents').addEventListener('click', function () {
    const classId = document.getElementById('school_class_id').value;
    const sectionId = document.getElementById('section_id').value;
    const date = document.getElementById('date').value;

    if (!classId || !sectionId || !date) {
        alert('Please select class, section and date first.');
        return;
    }

    this.textContent = 'Loading...';
    this.disabled = true;

    fetch(`{{ route('teacher.attendance.students') }}?class_id=${classId}&section_id=${sectionId}&date=${date}`)
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('studentsBody');
            tbody.innerHTML = '';

            if (data.students.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">No students found.</td></tr>';
            } else {
                data.students.forEach((student, index) => {
                    const existingStatus = data.existingAttendance[student.id] || 'present';
                    const displayName = (student.first_name && student.last_name)
                        ? student.first_name + ' ' + student.last_name
                        : student.name;

                    const row = `
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/30">
                            <td class="whitespace-nowrap px-4 py-3.5 text-sm text-gray-500 dark:text-gray-400">${index + 1}</td>
                            <td class="whitespace-nowrap px-4 py-3.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                                ${displayName}
                                <input type="hidden" name="attendance[${index}][user_id]" value="${student.id}">
                            </td>
                            <td class="whitespace-nowrap px-4 py-3.5 text-sm">
                                <select name="attendance[${index}][status]" class="status-select rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                    <option value="present" ${existingStatus === 'present' ? 'selected' : ''}>Present</option>
                                    <option value="absent" ${existingStatus === 'absent' ? 'selected' : ''}>Absent</option>
                                    <option value="late" ${existingStatus === 'late' ? 'selected' : ''}>Late</option>
                                    <option value="excused" ${existingStatus === 'excused' ? 'selected' : ''}>Excused</option>
                                </select>
                            </td>
                            <td class="whitespace-nowrap px-4 py-3.5 text-sm">
                                <input type="text" name="attendance[${index}][remarks]" placeholder="Optional remarks"
                                       class="w-full rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            </td>
                        </tr>
                    `;
                    tbody.insertAdjacentHTML('beforeend', row);
                });

                document.getElementById('studentCount').textContent = `${data.students.length} student(s) loaded`;
            }

            document.getElementById('studentsList').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading students. Please try again.');
        })
        .finally(() => {
            this.textContent = 'Reload Students';
            this.disabled = false;
        });
});

document.getElementById('markAllPresent').addEventListener('click', function () {
    document.querySelectorAll('.status-select').forEach(select => {
        select.value = 'present';
    });
});

document.getElementById('markAllAbsent').addEventListener('click', function () {
    document.querySelectorAll('.status-select').forEach(select => {
        select.value = 'absent';
    });
});
</script>
@endsection
