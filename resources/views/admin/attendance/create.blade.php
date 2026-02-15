@extends('layouts.app')

@section('content')
<div class="flex h-screen overflow-hidden">
    @include('partials.sidebar')

    <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
        @include('partials.overlay')
        @include('partials.header')

        <main>
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5 lg:p-6">
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Mark Attendance</h3>
    </div>

    <form method="POST" action="{{ route('admin.attendance.store') }}" id="attendanceForm">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <label for="school_class_id" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Class <span class="text-red-500">*</span></label>
                <select name="school_class_id" id="school_class_id" required class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('school_class_id') border-red-500 @enderror">
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
                <select name="section_id" id="section_id" required class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('section_id') border-red-500 @enderror">
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
                <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" required class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('date') border-red-500 @enderror">
                @error('date')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <button type="button" id="loadStudents" class="rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-900 dark:bg-white/10 dark:hover:bg-white/20">
                Load Students
            </button>
        </div>

        <div id="studentsList" class="hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr>
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
                <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600">Save Attendance</button>
                <a href="{{ route('admin.attendance.index') }}" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">Cancel</a>
            </div>
        </div>
    </form>
</div>


   </main>
    </div>
</div>
<script>
document.getElementById('loadStudents').addEventListener('click', function() {
    const classId = document.getElementById('school_class_id').value;
    const sectionId = document.getElementById('section_id').value;
    const date = document.getElementById('date').value;

    if (!classId || !sectionId || !date) {
        alert('Please select class, section and date');
        return;
    }

    fetch(`{{ route('admin.attendance.students') }}?class_id=${classId}&section_id=${sectionId}&date=${date}`)
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('studentsBody');
            tbody.innerHTML = '';

            data.students.forEach((student, index) => {
                const existingStatus = data.existingAttendance[student.id] || 'present';
                const row = `
                    <tr>
                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-700 dark:text-gray-300">
                            ${student.name}
                            <input type="hidden" name="attendance[${index}][user_id]" value="${student.id}">
                        </td>
                        <td class="whitespace-nowrap px-4 py-4 text-sm">
                            <select name="attendance[${index}][status]" class="rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                <option value="present" ${existingStatus === 'present' ? 'selected' : ''}>Present</option>
                                <option value="absent" ${existingStatus === 'absent' ? 'selected' : ''}>Absent</option>
                                <option value="late" ${existingStatus === 'late' ? 'selected' : ''}>Late</option>
                                <option value="excused" ${existingStatus === 'excused' ? 'selected' : ''}>Excused</option>
                            </select>
                        </td>
                        <td class="whitespace-nowrap px-4 py-4 text-sm">
                            <input type="text" name="attendance[${index}][remarks]" placeholder="Optional remarks" class="rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        </td>
                    </tr>
                `;
                tbody.insertAdjacentHTML('beforeend', row);
            });

            document.getElementById('studentsList').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading students');
        });
});
</script>
@endsection