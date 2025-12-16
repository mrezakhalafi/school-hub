<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SecurityGuardController;
use App\Http\Controllers\OfficeBoyController;
use Illuminate\Support\Facades\Route;

// Welcome page
Route::get('/', function () {
    return view('welcome_custom');
});

// Dashboard after login
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Attendance routes
Route::post('/attendance', [AttendanceController::class, 'store'])
    ->middleware(['auth'])
    ->name('attendance.store');

Route::get('/api/user/{user}/attendances', [AttendanceController::class, 'getUserAttendance'])
    ->middleware(['auth'])
    ->name('user.attendances.api');

// Security Guard routes
Route::resource('security-guards', SecurityGuardController::class)
    ->middleware(['auth']);

Route::get('security-guards/{securityGuard}/qr', [SecurityGuardController::class, 'generateSecurityGuardQR'])->name('security-guards.qr');

// Office Boy routes
Route::resource('office-boys', OfficeBoyController::class)
    ->middleware(['auth']);

Route::get('office-boys/{officeBoy}/qr', [OfficeBoyController::class, 'generateOfficeBoyQR'])->name('office-boys.qr');

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
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
