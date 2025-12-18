<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StudentController extends Controller
{
    private function authorizeResource($action = 'read')
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Access denied.');
        }

        // Admins can perform all actions
        if ($user->isAdmin()) {
            return true;
        }

        // Teachers and students can only read
        if ($action === 'read') {
            return true;
        }

        abort(403, 'Access denied. Only read operations are allowed for your role.');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorizeResource('read');

        $query = Student::with(['class', 'permissionReports'])->withCount('permissionReports');

        // Search functionality
        if ($request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('first_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('last_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('student_id', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('class', function($q) use ($searchTerm) {
                      $q->where('name', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }

        // Filter by class
        if ($request->class_id) {
            $query->where('class_id', $request->class_id);
        }

        // Filter by gender
        if ($request->gender) {
            $query->where('gender', $request->gender);
        }

        $students = $query->paginate(10);
        $classes = ClassModel::all(); // For the filter dropdown
        $genders = ['male', 'female']; // Available gender options

        return view('students.index', compact('students', 'classes', 'genders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorizeResource('write');
        $classes = ClassModel::all();
        return view('students.create', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorizeResource('write');
        $request->validate([
            'student_id' => 'required|unique:students,student_id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'class_id' => 'nullable|exists:classes,id',
        ]);

        $studentData = $request->all();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('students', 'public');
            $studentData['profile_image'] = $path;
        }

        Student::create($studentData);

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $this->authorizeResource('read');
        $student->load('class', 'parents');
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $this->authorizeResource('write');
        $classes = ClassModel::all();
        return view('students.edit', compact('student', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $this->authorizeResource('write');
        $request->validate([
            'student_id' => 'required|unique:students,student_id,' . $student->id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'class_id' => 'nullable|exists:classes,id',
        ]);

        $studentData = $request->all();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($student->profile_image) {
                Storage::disk('public')->delete($student->profile_image);
            }

            $path = $request->file('profile_image')->store('students', 'public');
            $studentData['profile_image'] = $path;
        } elseif ($request->has('remove_profile_image') && $request->remove_profile_image) {
            // Remove existing image
            if ($student->profile_image) {
                Storage::disk('public')->delete($student->profile_image);
            }
            $studentData['profile_image'] = null;
        } else {
            unset($studentData['profile_image']); // Don't update image if not provided
        }

        $student->update($studentData);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $this->authorizeResource('write');
        // Delete profile image if exists
        if ($student->profile_image) {
            Storage::disk('public')->delete($student->profile_image);
        }

        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
    
    /**
     * Generate QR code for a student.
     */
    public function generateStudentQR(Student $student)
    {
        // Create a unique identifier for the student
        $data = [
            'type' => 'student',
            'id' => $student->id,
            'name' => $student->first_name . ' ' . $student->last_name,
            'student_id' => $student->student_id,
            'timestamp' => now()->toISOString(),
        ];
        
        $qrCode = QrCode::size(300)->generate(json_encode($data));
        
        return Response::make($qrCode, 200, [
            'Content-Type' => 'image/svg+xml'
        ]);
    }
}
