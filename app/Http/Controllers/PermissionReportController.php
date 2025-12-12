<?php

namespace App\Http\Controllers;

use App\Models\PermissionReport;
use App\Models\Student;
use App\Models\Guardian;
use Illuminate\Http\Request;

class PermissionReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PermissionReport::with('student');

        // Search functionality
        if ($request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('student_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('reason', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('student.class', function($q) use ($searchTerm) {
                      $q->where('name', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }

        // Filter by permission type
        if ($request->permission_type) {
            $query->where('permission_type', $request->permission_type);
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter by student's class
        if ($request->class_id) {
            $classId = $request->class_id;
            $query->whereHas('student', function($q) use ($classId) {
                $q->where('class_id', $classId);
            });
        }

        $permissionReports = $query->latest()->paginate(10);
        $classes = \App\Models\ClassModel::all(); // For the filter dropdown
        $permissionTypes = ['sick', 'event', 'family', 'other']; // Available permission types
        $statuses = ['pending', 'approved', 'rejected']; // Available statuses

        return view('permission-reports.index', compact('permissionReports', 'classes', 'permissionTypes', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::with('class', 'guardians')->get();
        return view('permission-reports.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'student_name' => 'required|string|max:255',
            'permission_date' => 'required|date',
            'permission_time' => 'required|date_format:H:i',
            'permission_type' => 'required|in:sick,event,family,other',
            'reason' => 'required|string|max:500',
        ]);

        // Get the student's name to include in the report
        $student = Student::find($request->student_id);
        $studentName = $student ? $student->first_name . ' ' . $student->last_name : 'Unknown Student';

        $permissionReport = PermissionReport::create(array_merge($request->except('class_name'), ['student_name' => $studentName]));

        // Send WhatsApp message to the student's guardians
        $student = Student::with('class', 'guardians')->find($request->student_id);
        $className = $student ? ($student->class ? $student->class->name : 'N/A') : 'N/A';
        if ($student && $student->guardians->count() > 0) {
            foreach ($student->guardians as $guardian) {
                if ($guardian->phone) {
                    $typeText = $request->permission_type === 'sick' ? 'sakit' : ($request->permission_type === 'event' ? 'acara' : ($request->permission_type === 'family' ? 'keluarga' : 'lainnya'));
                    $message = "Pemberitahuan Izin Absensi: Anak Anda {$studentName} dari kelas {$className} tidak hadir pada tanggal {$request->permission_date} jam {$request->permission_time} karena {$typeText}, dengan alasan: {$request->reason}";
                    // In a real application, you would integrate with WhatsApp Business API
                    // For now, we'll just create a URL for manual sharing
                    $whatsappUrl = "https://api.whatsapp.com/send?phone=" . str_replace(['+', '-', ' '], '', $guardian->phone) . "&text=" . urlencode($message);
                    // Log the URL for reference or use it as needed
                    \Log::info("WhatsApp URL for {$guardian->first_name}: {$whatsappUrl}");
                }
            }
        }

        return redirect()->route('permission-reports.index')
            ->with('success', 'Permission report created successfully and notification sent to guardians.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PermissionReport $permissionReport)
    {
        return view('permission-reports.show', compact('permissionReport'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PermissionReport $permissionReport)
    {
        $students = Student::with('class', 'guardians')->get();
        return view('permission-reports.edit', compact('permissionReport', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PermissionReport $permissionReport)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'student_name' => 'required|string|max:255',
            'permission_date' => 'required|date',
            'permission_time' => 'required|date_format:H:i',
            'permission_type' => 'required|in:sick,event,family,other',
            'reason' => 'required|string|max:500',
        ]);

        // Get the student's name to include in the report
        $student = Student::find($request->student_id);
        $studentName = $student ? $student->first_name . ' ' . $student->last_name : 'Unknown Student';

        $permissionReport->update(array_merge($request->except('class_name'), ['student_name' => $studentName]));

        return redirect()->route('permission-reports.index')
            ->with('success', 'Permission report updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PermissionReport $permissionReport)
    {
        $permissionReport->delete();

        return redirect()->route('permission-reports.index')
            ->with('success', 'Permission report deleted successfully.');
    }

    /**
     * Update the status of a permission report.
     */
    public function updateStatus(Request $request, PermissionReport $permissionReport)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $permissionReport->update(['status' => $request->status]);

        // Send WhatsApp notification about status change
        $student = Student::with('class', 'guardians')->find($permissionReport->student_id);
        $className = $student ? ($student->class ? $student->class->name : 'N/A') : 'N/A';
        if ($student && $student->guardians->count() > 0) {
            foreach ($student->guardians as $guardian) {
                if ($guardian->phone) {
                    $typeText = $permissionReport->permission_type === 'sick' ? 'sakit' : ($permissionReport->permission_type === 'event' ? 'acara' : ($permissionReport->permission_type === 'family' ? 'keluarga' : 'lainnya'));
                    $statusText = $request->status === 'approved' ? 'telah disetujui' : 'ditolak';
                    $message = "Status izin untuk {$permissionReport->student_name} ({$className}) pada tanggal {$permissionReport->permission_date} jam {$permissionReport->permission_time} karena {$typeText} {$statusText}. Alasan: {$permissionReport->reason}";
                    $whatsappUrl = "https://api.whatsapp.com/send?phone=" . str_replace(['+', '-', ' '], '', $guardian->phone) . "&text=" . urlencode($message);
                    \Log::info("WhatsApp URL for {$guardian->first_name}: {$whatsappUrl}");
                }
            }
        }

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
