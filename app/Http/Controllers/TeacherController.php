<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Teacher::with('class'); // Include class relationship for filtering

        // Search functionality
        if ($request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('first_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('last_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('class', function($q) use ($searchTerm) {
                      $q->where('name', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }

        // Filter by gender
        if ($request->gender) {
            $query->where('gender', $request->gender);
        }

        // Filter by class
        if ($request->class_id) {
            $query->where('class_id', $request->class_id);
        }

        $teachers = $query->paginate(10);
        $classes = \App\Models\ClassModel::all(); // For the filter dropdown
        $genders = ['male', 'female']; // Available gender options

        return view('teachers.index', compact('teachers', 'classes', 'genders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $teacherData = $request->all();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('teachers', 'public');
            $teacherData['profile_image'] = $path;
        }

        Teacher::create($teacherData);

        return redirect()->route('teachers.index')->with('success', 'Teacher created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        // Load relationships if needed
        $teacher->load('class');
        return view('teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email,' . $teacher->id,
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $teacherData = $request->all();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($teacher->profile_image) {
                Storage::disk('public')->delete($teacher->profile_image);
            }

            $path = $request->file('profile_image')->store('teachers', 'public');
            $teacherData['profile_image'] = $path;
        } elseif ($request->has('remove_profile_image') && $request->remove_profile_image) {
            // Remove existing image
            if ($teacher->profile_image) {
                Storage::disk('public')->delete($teacher->profile_image);
            }
            $teacherData['profile_image'] = null;
        } else {
            unset($teacherData['profile_image']); // Don't update image if not provided
        }

        $teacher->update($teacherData);

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        // Delete profile image if exists
        if ($teacher->profile_image) {
            Storage::disk('public')->delete($teacher->profile_image);
        }

        $teacher->delete();

        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }
    
    /**
     * Generate QR code for a teacher.
     */
    public function generateTeacherQR(Teacher $teacher)
    {
        // Create a unique identifier for the teacher
        $data = [
            'type' => 'teacher',
            'id' => $teacher->id,
            'name' => $teacher->first_name . ' ' . $teacher->last_name,
            'email' => $teacher->email,
            'timestamp' => now()->toISOString(),
        ];
        
        $qrCode = QrCode::size(300)->generate(json_encode($data));
        
        return Response::make($qrCode, 200, [
            'Content-Type' => 'image/svg+xml'
        ]);
    }
}
