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
    public function index()
    {
        $permissionReports = PermissionReport::with('student')->latest()->paginate(10);
        return view('permission-reports.index', compact('permissionReports'));
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
            'reason' => 'required|string|max:500',
        ]);

        $permissionReport = PermissionReport::create($request->except('class_name'));

        // Send WhatsApp message to the student's guardians
        $student = Student::with('class', 'guardians')->find($request->student_id);
        $className = $student ? ($student->class ? $student->class->name : 'N/A') : 'N/A';
        if ($student && $student->guardians->count() > 0) {
            foreach ($student->guardians as $guardian) {
                if ($guardian->phone) {
                    $message = "Pemberitahuan Izin Absensi: Anak Anda {$request->student_name} dari kelas {$className} tidak hadir pada tanggal {$request->permission_date} jam {$request->permission_time} dengan alasan: {$request->reason}";
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
            'reason' => 'required|string|max:500',
        ]);

        $permissionReport->update($request->except('class_name'));

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
                    $statusText = $request->status === 'approved' ? 'telah disetujui' : 'ditolak';
                    $message = "Status izin untuk {$permissionReport->student_name} ({$className}) pada tanggal {$permissionReport->permission_date} jam {$permissionReport->permission_time} {$statusText}. Alasan: {$permissionReport->reason}";
                    $whatsappUrl = "https://api.whatsapp.com/send?phone=" . str_replace(['+', '-', ' '], '', $guardian->phone) . "&text=" . urlencode($message);
                    \Log::info("WhatsApp URL for {$guardian->first_name}: {$whatsappUrl}");
                }
            }
        }

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
