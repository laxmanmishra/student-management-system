<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\StudentController;


Route::get('/', function () {
    return view('welcome');
})->name('home');



Route::get('/login', [LoginController::class, 'show'])
    ->middleware(['guest', 'guest:admin'])
    ->name('login');

Route::post('/login', [LoginController::class, 'store'])
    ->middleware(['guest', 'guest:admin'])
    ->name('login.store');



Route::get('/admin', function () {
    return view('admin.dashboard', ['page' => 'Admin Dashboard']);
})->middleware('auth:admin')->name('admin');

Route::get('/admin/profile', function () {
    return view('admin.profile', ['page' => 'Profile']);
})->middleware('auth:admin')->name('admin.profile');

Route::get('/teacher', fn () => view('teacher.dashboard', ['page' => 'Teacher Dashboard']))
    ->middleware(['auth', 'role:teacher'])
    ->name('teacher.dashboard');

Route::get('/teacher/profile', function () {
    return view('teacher.profile', ['page' => 'Profile']);
})->middleware(['auth','role:teacher'])->name('teacher.profile');    
 
Route::get('/student', fn () => view('student.dashboard', ['page' => 'Student Dashboard']))
    ->middleware(['auth', 'role:student'])
    ->name('student.dashboard');

Route::get('/student/profile', function () {
    return view('student.profile', ['page' => 'Profile']);
})->middleware(['auth','role:student'])->name('student.profile');    
 
Route::put('/student/profile/update', [StudentController::class, 'update'])->name('student.profile.update');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/test', function () {
    return 'Route working!';
});

// Route::get('/signup', function () {
//     return view('signup');
// })->name('signup');