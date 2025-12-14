<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;

// Welcome page
Route::get('/', function () {
    return view('welcome_custom');
});

// Dashboard after login
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Attendance route
Route::post('/attendance', [AttendanceController::class, 'store'])
    ->middleware(['auth'])
    ->name('attendance.store');

// Student routes
Route::resource('students', StudentController::class)
    ->middleware(['auth']);

Route::get('students/{student}/qr', [StudentController::class, 'generateStudentQR'])->name('students.qr');

// Teacher routes
Route::resource('teachers', TeacherController::class)
    ->middleware(['auth']);

Route::get('teachers/{teacher}/qr', [TeacherController::class, 'generateTeacherQR'])->name('teachers.qr');

// Class routes
Route::resource('classes', ClassController::class)
    ->middleware(['auth']);

// Guardian routes
Route::resource('guardians', GuardianController::class)
    ->middleware(['auth']);

// Event routes
Route::resource('events', EventController::class)
    ->middleware(['auth']);

// Permission Report routes
Route::resource('permission-reports', \App\Http\Controllers\PermissionReportController::class)
    ->middleware(['auth']);

// Update status route
Route::post('/permission-reports/{permissionReport}/status', [\App\Http\Controllers\PermissionReportController::class, 'updateStatus'])
    ->middleware(['auth'])
    ->name('permission-reports.status.update');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
