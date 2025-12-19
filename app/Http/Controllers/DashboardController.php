<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ClassModel;
use App\Models\SchoolEvent;
use App\Models\PermissionReport;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // If user is admin, show full dashboard
        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }
        // If user is teacher, show teacher dashboard
        elseif ($user->isTeacher()) {
            return $this->teacherDashboard();
        }
        // If user is student, show student dashboard
        else {
            return $this->studentDashboard();
        }
    }

    public function adminDashboard()
    {
        // Get summary data for the dashboard
        $studentCount = Student::count();
        $teacherCount = Teacher::count();
        $classCount = ClassModel::count();
        $eventCount = SchoolEvent::count();
        $permissionReportCount = PermissionReport::count();
        $securityGuardCount = \App\Models\SecurityGuard::count();
        $officeBoyCount = \App\Models\OfficeBoy::count();
        $parentCount = \App\Models\ParentModel::count();

        // Get recent attendances for admin
        $recentAttendances = Attendance::with('user')
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();

        // Get recent events
        $recentEvents = SchoolEvent::orderBy('start_date', 'desc')->limit(5)->get();

        // Get counts for new features
        $healthRecordCount = \App\Models\HealthRecord::count();
        $financeRecordCount = \App\Models\FinanceRecord::count();

        // Pass data to the view
        return view('dashboard', compact(
            'studentCount',
            'teacherCount',
            'classCount',
            'eventCount',
            'permissionReportCount',
            'securityGuardCount',
            'officeBoyCount',
            'parentCount',
            'healthRecordCount',
            'financeRecordCount',
            'recentEvents',
            'recentAttendances'
        ));
    }

    public function teacherDashboard()
    {
        // Get recent events for teacher
        $recentEvents = SchoolEvent::orderBy('start_date', 'desc')->limit(5)->get();

        return view('dashboard.teacher', compact('recentEvents'));
    }

    public function studentDashboard()
    {
        // Get recent events for student
        $recentEvents = SchoolEvent::orderBy('start_date', 'desc')->limit(5)->get();

        return view('dashboard.student', compact('recentEvents'));
    }
}
