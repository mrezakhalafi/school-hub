<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ClassModel;
use App\Models\SchoolEvent;
use App\Models\PermissionReport;

class DashboardController extends Controller
{
    public function index()
    {
        // Get summary data for the dashboard
        $studentCount = Student::count();
        $teacherCount = Teacher::count();
        $classCount = ClassModel::count();
        $eventCount = SchoolEvent::count();
        $permissionReportCount = PermissionReport::count();

        // Get recent events
        $recentEvents = SchoolEvent::orderBy('start_date', 'desc')->limit(5)->get();

        // Pass data to the view
        return view('dashboard', compact('studentCount', 'teacherCount', 'classCount', 'eventCount', 'permissionReportCount', 'recentEvents'));
    }
}
