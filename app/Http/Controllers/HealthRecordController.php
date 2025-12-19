<?php

namespace App\Http\Controllers;

use App\Models\HealthRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HealthRecordController extends Controller
{
    public function index()
    {
        $healthRecords = HealthRecord::with('student')->latest()->paginate(10);
        return view('health-records.index', compact('healthRecords'));
    }

    public function create()
    {
        $students = User::where('role', 'student')->get();
        return view('health-records.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|exists:users,id',
            'height' => 'nullable|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'blood_pressure' => 'nullable|string|max:20',
            'vision_test_result' => 'nullable|string|max:50',
            'hearing_test_result' => 'nullable|string|max:50',
            'dental_health' => 'nullable|string|max:100',
            'allergies' => 'nullable|array',
            'allergies.*' => 'string|max:100',
            'medical_conditions' => 'nullable|array',
            'medical_conditions.*' => 'string|max:100',
            'medications' => 'nullable|string',
            'emergency_contact' => 'nullable|string|max:255',
            'immunization_records' => 'nullable|array',
            'immunization_records.*' => 'string|max:100',
            'date_checked' => 'nullable|date',
            'checked_by' => 'nullable|string|max:255',
        ]);

        HealthRecord::create($validatedData);

        return redirect()->route('health-records.index')
            ->with('success', 'Health record created successfully.');
    }

    public function show(HealthRecord $healthRecord)
    {
        $healthRecord->load('student');
        return view('health-records.show', compact('healthRecord'));
    }

    public function edit(HealthRecord $healthRecord)
    {
        $students = User::where('role', 'student')->get();
        return view('health-records.edit', compact('healthRecord', 'students'));
    }

    public function update(Request $request, HealthRecord $healthRecord)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|exists:users,id',
            'height' => 'nullable|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'blood_pressure' => 'nullable|string|max:20',
            'vision_test_result' => 'nullable|string|max:50',
            'hearing_test_result' => 'nullable|string|max:50',
            'dental_health' => 'nullable|string|max:100',
            'allergies' => 'nullable|array',
            'allergies.*' => 'string|max:100',
            'medical_conditions' => 'nullable|array',
            'medical_conditions.*' => 'string|max:100',
            'medications' => 'nullable|string',
            'emergency_contact' => 'nullable|string|max:255',
            'immunization_records' => 'nullable|array',
            'immunization_records.*' => 'string|max:100',
            'date_checked' => 'nullable|date',
            'checked_by' => 'nullable|string|max:255',
        ]);

        $healthRecord->update($validatedData);

        return redirect()->route('health-records.index')
            ->with('success', 'Health record updated successfully.');
    }

    public function destroy(HealthRecord $healthRecord)
    {
        $healthRecord->delete();

        return redirect()->route('health-records.index')
            ->with('success', 'Health record deleted successfully.');
    }
}
