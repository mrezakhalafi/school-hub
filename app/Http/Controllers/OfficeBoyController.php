<?php

namespace App\Http\Controllers;

use App\Models\OfficeBoy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class OfficeBoyController extends Controller
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

        // Other roles have limited access
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
        $query = OfficeBoy::query();

        // Search functionality
        if ($request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('first_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('last_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('employee_id', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('department', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filter by gender
        if ($request->gender) {
            $query->where('gender', $request->gender);
        }

        // Filter by department
        if ($request->department) {
            $query->where('department', $request->department);
        }

        $officeBoys = $query->paginate(10);
        $genders = ['male', 'female']; // Available gender options
        $departments = OfficeBoy::select('department')->distinct()->pluck('department')->filter(); // Get distinct departments

        // Calculate summary data for the cards
        $totalMale = OfficeBoy::where('gender', 'male')->count();
        $totalFemale = OfficeBoy::where('gender', 'female')->count();

        return view('office-boys.index', compact('officeBoys', 'genders', 'departments', 'totalMale', 'totalFemale'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorizeResource('write');
        return view('office-boys.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorizeResource('write');
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:office_boys,email',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'employee_id' => 'nullable|string|max:50|unique:office_boys,employee_id',
            'department' => 'nullable|string|max:255',
            'hire_date' => 'nullable|date',
        ]);

        $officeBoyData = $request->all();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('office_boys', 'public');
            $officeBoyData['profile_image'] = $path;
        }

        OfficeBoy::create($officeBoyData);

        return redirect()->route('office-boys.index')->with('success', 'Office Boy created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OfficeBoy $officeBoy)
    {
        $this->authorizeResource('read');
        return view('office-boys.show', compact('officeBoy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OfficeBoy $officeBoy)
    {
        $this->authorizeResource('write');
        return view('office-boys.edit', compact('officeBoy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OfficeBoy $officeBoy)
    {
        $this->authorizeResource('write');
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:office_boys,email,' . $officeBoy->id,
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'employee_id' => 'nullable|string|max:50|unique:office_boys,employee_id,' . $officeBoy->id,
            'department' => 'nullable|string|max:255',
            'hire_date' => 'nullable|date',
        ]);

        $officeBoyData = $request->all();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($officeBoy->profile_image) {
                Storage::disk('public')->delete($officeBoy->profile_image);
            }

            $path = $request->file('profile_image')->store('office_boys', 'public');
            $officeBoyData['profile_image'] = $path;
        } elseif ($request->has('remove_profile_image') && $request->remove_profile_image) {
            // Remove existing image
            if ($officeBoy->profile_image) {
                Storage::disk('public')->delete($officeBoy->profile_image);
            }
            $officeBoyData['profile_image'] = null;
        } else {
            unset($officeBoyData['profile_image']); // Don't update image if not provided
        }

        $officeBoy->update($officeBoyData);

        return redirect()->route('office-boys.index')->with('success', 'Office Boy updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OfficeBoy $officeBoy)
    {
        $this->authorizeResource('write');
        // Delete profile image if exists
        if ($officeBoy->profile_image) {
            Storage::disk('public')->delete($officeBoy->profile_image);
        }

        $officeBoy->delete();

        return redirect()->route('office-boys.index')->with('success', 'Office Boy deleted successfully.');
    }

    /**
     * Generate QR code for an office boy.
     */
    public function generateOfficeBoyQR(OfficeBoy $officeBoy)
    {
        // Create a unique identifier for the office boy
        $data = [
            'type' => 'office_boy',
            'id' => $officeBoy->id,
            'name' => $officeBoy->first_name . ' ' . $officeBoy->last_name,
            'employee_id' => $officeBoy->employee_id,
            'department' => $officeBoy->department,
            'timestamp' => now()->toISOString(),
        ];

        $qrCode = QrCode::size(300)->generate(json_encode($data));

        return Response::make($qrCode, 200, [
            'Content-Type' => 'image/svg+xml'
        ]);
    }
}
