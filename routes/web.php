<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\ExaminationController;
use App\Http\Controllers\Admin\FeeController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Student\AttendanceController as StudentAttendanceController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\ExaminationController as StudentExaminationController;
use App\Http\Controllers\Student\FeeController as StudentFeeController;
use App\Http\Controllers\Student\NotificationController as StudentNotificationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Teacher\AttendanceController as TeacherAttendanceController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\ExaminationController as TeacherExaminationController;
use App\Http\Controllers\Teacher\FeeController as TeacherFeeController;
use App\Http\Controllers\Teacher\NotificationController as TeacherNotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [LoginController::class, 'show'])
    ->middleware(['guest', 'guest:admin'])
    ->name('login');

Route::get('/login/search', [LoginController::class, 'search'])
    ->name('login.search');

Route::post('/login', [LoginController::class, 'store'])
    ->middleware(['guest', 'guest:admin'])
    ->middleware('throttle:login')
    ->name('login.store');

Route::get('/admin', [AdminDashboardController::class, 'index'])
    ->middleware('auth:admin')
    ->name('admin');

Route::get('/admin/profile', function () {
    return view('admin.profile', ['page' => 'Profile']);
})->middleware('auth:admin')->name('admin.profile');

Route::get('/teacher', [TeacherDashboardController::class, 'index'])
    ->middleware(['auth', 'role:teacher'])
    ->name('teacher.dashboard');

Route::get('/teacher/profile', function () {
    return view('teacher.profile', ['page' => 'Profile']);
})->middleware(['auth', 'role:teacher'])->name('teacher.profile');

// Teacher Feature Routes
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    // Attendance Management
    Route::get('attendance', [TeacherAttendanceController::class, 'index'])->name('attendance.index');
    Route::get('attendance/create', [TeacherAttendanceController::class, 'create'])->name('attendance.create');
    Route::post('attendance', [TeacherAttendanceController::class, 'store'])->name('attendance.store');
    Route::get('attendance/{attendance}/edit', [TeacherAttendanceController::class, 'edit'])->name('attendance.edit');
    Route::put('attendance/{attendance}', [TeacherAttendanceController::class, 'update'])->name('attendance.update');
    Route::get('attendance-students', [TeacherAttendanceController::class, 'getStudents'])->name('attendance.students');
    Route::get('attendance-report', [TeacherAttendanceController::class, 'report'])->name('attendance.report');

    // Examination Management
    Route::resource('examinations', TeacherExaminationController::class);

    // Fee Records (read-only)
    Route::get('fees', [TeacherFeeController::class, 'index'])->name('fees.index');
    Route::get('fees/{fee}', [TeacherFeeController::class, 'show'])->name('fees.show');

    // Notification Management
    Route::get('notifications', [TeacherNotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/create', [TeacherNotificationController::class, 'create'])->name('notifications.create');
    Route::post('notifications', [TeacherNotificationController::class, 'store'])->name('notifications.store');
    Route::get('notifications/{notification}', [TeacherNotificationController::class, 'show'])->name('notifications.show');
});

Route::get('/student', [StudentDashboardController::class, 'index'])
    ->middleware(['auth', 'role:student'])
    ->name('student.dashboard');

Route::get('/student/profile', function () {
    return view('student.profile', ['page' => 'Profile']);
})->middleware(['auth', 'role:student'])->name('student.profile');

Route::put('/student/profile/update', [StudentController::class, 'update'])->name('student.profile.update');

// Student Feature Routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    // Attendance (view only)
    Route::get('attendance', [StudentAttendanceController::class, 'index'])->name('attendance.index');

    // Examinations (view only)
    Route::get('examinations', [StudentExaminationController::class, 'index'])->name('examinations.index');
    Route::get('examinations/{examination}', [StudentExaminationController::class, 'show'])->name('examinations.show');

    // Fees (view only)
    Route::get('fees', [StudentFeeController::class, 'index'])->name('fees.index');
    Route::get('fees/{fee}', [StudentFeeController::class, 'show'])->name('fees.show');

    // Notifications (view only)
    Route::get('notifications', [StudentNotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/{notification}', [StudentNotificationController::class, 'show'])->name('notifications.show');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/test', function () {
    return 'Route working!';
});

Route::get('/search', [SearchController::class, 'search'])
    ->middleware(['auth:admin'])
    ->name('search');

// Admin User Management Routes
Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    // Teacher Management
    Route::resource('teachers', TeacherController::class);
    Route::post('teachers/{teacher}/reset-password', [TeacherController::class, 'resetPassword'])
        ->name('teachers.reset-password');

    // Student Management
    Route::resource('students', AdminStudentController::class);
    Route::post('students/{student}/reset-password', [AdminStudentController::class, 'resetPassword'])
        ->name('students.reset-password');
    Route::patch('students/{student}/change-role', [AdminStudentController::class, 'changeRole'])
        ->name('students.change-role');

    // Academic Management - Classes
    Route::resource('classes', SchoolClassController::class);
    Route::post('classes/{class}/assign-teacher', [SchoolClassController::class, 'assignTeacher'])
        ->name('classes.assign-teacher');

    // Academic Management - Sections
    Route::resource('sections', SectionController::class);

    // Academic Management - Subjects
    Route::resource('subjects', SubjectController::class);
    Route::post('subjects/{subject}/assign-teachers', [SubjectController::class, 'assignTeachers'])
        ->name('subjects.assign-teachers');

    // Attendance Management
    Route::resource('attendance', AttendanceController::class);
    Route::get('attendance-students', [AttendanceController::class, 'getStudents'])
        ->name('attendance.students');
    Route::get('attendance-report', [AttendanceController::class, 'report'])
        ->name('attendance.report');

    // Examination Management
    Route::resource('examinations', ExaminationController::class);

    // Fee Management
    Route::resource('fees', FeeController::class);
    Route::post('fees/{fee}/payment', [FeeController::class, 'recordPayment'])
        ->name('fees.payment');

    // Notification Management
    Route::resource('notifications', NotificationController::class);
});
