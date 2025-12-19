<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SecurityGuardController;
use App\Http\Controllers\OfficeBoyController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\HealthRecordController;
use App\Http\Controllers\FinanceRecordController;
use Illuminate\Support\Facades\Route;

// Welcome page
Route::get('/', function () {
    return view('welcome_custom');
});

// Dashboard after login - redirects based on user role
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->isAdmin()) {
        return redirect()->route('dashboard.admin');
    } elseif ($user->isTeacher()) {
        return redirect()->route('dashboard.teacher');
    } else {
        return redirect()->route('dashboard.student');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Role-based dashboard routes
Route::get('/dashboard/admin', [DashboardController::class, 'adminDashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.admin');

Route::get('/dashboard/teacher', [DashboardController::class, 'teacherDashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.teacher');

Route::get('/dashboard/student', [DashboardController::class, 'studentDashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.student');

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

// Schedule routes - nested under classes
Route::prefix('classes/{classId}')->name('schedules.')->middleware(['auth'])->group(function () {
    Route::get('/schedules', [ScheduleController::class, 'index'])->name('index');
    Route::get('/schedules/create', [ScheduleController::class, 'create'])->name('create');
    Route::post('/schedules', [ScheduleController::class, 'store'])->name('store');
    Route::get('/schedules/{schedule}/edit', [ScheduleController::class, 'edit'])->name('edit');
    Route::put('/schedules/{schedule}', [ScheduleController::class, 'update'])->name('update');
    Route::delete('/schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('destroy');
});

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

// Parent routes
Route::resource('parents', ParentController::class)
    ->middleware(['auth']);

// Event routes
Route::resource('events', EventController::class)
    ->middleware(['auth']);

// Permission Report routes
Route::resource('permission-reports', \App\Http\Controllers\PermissionReportController::class)
    ->middleware(['auth']);

// Health Record routes
Route::resource('health-records', HealthRecordController::class)
    ->middleware(['auth']);

// Finance Record routes
Route::resource('finance-records', FinanceRecordController::class)
    ->middleware(['auth']);

// Mark finance record as paid
Route::post('/finance-records/{financeRecord}/mark-as-paid', [FinanceRecordController::class, 'markAsPaid'])
    ->middleware(['auth'])
    ->name('finance-records.markAsPaid');

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
