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
use App\Http\Controllers\StudentController;
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
    ->name('login.store');

Route::get('/admin', [AdminDashboardController::class, 'index'])
    ->middleware('auth:admin')
    ->name('admin');

Route::get('/admin/profile', function () {
    return view('admin.profile', ['page' => 'Profile']);
})->middleware('auth:admin')->name('admin.profile');

Route::get('/teacher', fn () => view('teacher.dashboard', ['page' => 'Teacher Dashboard']))
    ->middleware(['auth', 'role:teacher'])
    ->name('teacher.dashboard');

Route::get('/teacher/profile', function () {
    return view('teacher.profile', ['page' => 'Profile']);
})->middleware(['auth', 'role:teacher'])->name('teacher.profile');

Route::get('/student', fn () => view('student.dashboard', ['page' => 'Student Dashboard']))
    ->middleware(['auth', 'role:student'])
    ->name('student.dashboard');

Route::get('/student/profile', function () {
    return view('student.profile', ['page' => 'Profile']);
})->middleware(['auth', 'role:student'])->name('student.profile');

Route::put('/student/profile/update', [StudentController::class, 'update'])->name('student.profile.update');

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
