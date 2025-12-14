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
            // Get summary data for the dashboard
            $studentCount = Student::count();
            $teacherCount = Teacher::count();
            $classCount = ClassModel::count();
            $eventCount = SchoolEvent::count();
            $permissionReportCount = PermissionReport::count();

            // Get recent attendances for admin
            $recentAttendances = Attendance::with('user')
                ->orderBy('date', 'desc')
                ->limit(10)
                ->get();

            // Get recent events
            $recentEvents = SchoolEvent::orderBy('start_date', 'desc')->limit(5)->get();

            // Pass data to the view
            return view('dashboard', compact(
                'studentCount',
                'teacherCount',
                'classCount',
                'eventCount',
                'permissionReportCount',
                'recentEvents',
                'recentAttendances'
            ));
        }
        // If user is teacher, show dashboard with events and access to teachers/students
        elseif ($user->isTeacher()) {
            // Get recent events for teacher
            $recentEvents = SchoolEvent::orderBy('start_date', 'desc')->limit(5)->get();

            // Get all teachers for teacher to view
            $teachers = Teacher::all();

            // Get all students for teacher to view
            $students = Student::all();

            return view('dashboard.teacher', compact(
                'recentEvents',
                'teachers',
                'students'
            ));
        }
        // If user is student, show dashboard with events and access to teachers
        else {
            // Get recent events for student
            $recentEvents = SchoolEvent::orderBy('start_date', 'desc')->limit(5)->get();

            // Get all teachers for student to view
            $teachers = Teacher::all();

            return view('dashboard.student', compact(
                'recentEvents',
                'teachers'
            ));
        }
    }
}
