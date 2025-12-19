<?php

namespace App\Http\Controllers;

use App\Models\SecurityGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SecurityGuardController extends Controller
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
        $query = SecurityGuard::query();

        // Search functionality
        if ($request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('first_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('last_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('badge_number', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filter by gender
        if ($request->gender) {
            $query->where('gender', $request->gender);
        }

        // Filter by shift
        if ($request->shift) {
            $query->where('shift', $request->shift);
        }

        $securityGuards = $query->paginate(10);
        $genders = ['male', 'female']; // Available gender options
        $shifts = ['morning', 'afternoon', 'night']; // Available shift options

        // Calculate summary data for the cards
        $totalMale = SecurityGuard::where('gender', 'male')->count();
        $totalFemale = SecurityGuard::where('gender', 'female')->count();

        return view('security-guards.index', compact('securityGuards', 'genders', 'shifts', 'totalMale', 'totalFemale'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorizeResource('write');
        return view('security-guards.create');
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
            'email' => 'required|email|unique:security_guards,email',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'badge_number' => 'nullable|string|max:50|unique:security_guards,badge_number',
            'shift' => 'nullable|in:morning,afternoon,night',
            'hire_date' => 'nullable|date',
        ]);

        $securityGuardData = $request->all();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('security_guards', 'public');
            $securityGuardData['profile_image'] = $path;
        }

        SecurityGuard::create($securityGuardData);

        return redirect()->route('security-guards.index')->with('success', 'Security Guard created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SecurityGuard $securityGuard)
    {
        $this->authorizeResource('read');
        return view('security-guards.show', compact('securityGuard'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SecurityGuard $securityGuard)
    {
        $this->authorizeResource('write');
        return view('security-guards.edit', compact('securityGuard'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SecurityGuard $securityGuard)
    {
        $this->authorizeResource('write');
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:security_guards,email,' . $securityGuard->id,
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'badge_number' => 'nullable|string|max:50|unique:security_guards,badge_number,' . $securityGuard->id,
            'shift' => 'nullable|in:morning,afternoon,night',
            'hire_date' => 'nullable|date',
        ]);

        $securityGuardData = $request->all();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($securityGuard->profile_image) {
                Storage::disk('public')->delete($securityGuard->profile_image);
            }

            $path = $request->file('profile_image')->store('security_guards', 'public');
            $securityGuardData['profile_image'] = $path;
        } elseif ($request->has('remove_profile_image') && $request->remove_profile_image) {
            // Remove existing image
            if ($securityGuard->profile_image) {
                Storage::disk('public')->delete($securityGuard->profile_image);
            }
            $securityGuardData['profile_image'] = null;
        } else {
            unset($securityGuardData['profile_image']); // Don't update image if not provided
        }

        $securityGuard->update($securityGuardData);

        return redirect()->route('security-guards.index')->with('success', 'Security Guard updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SecurityGuard $securityGuard)
    {
        $this->authorizeResource('write');
        // Delete profile image if exists
        if ($securityGuard->profile_image) {
            Storage::disk('public')->delete($securityGuard->profile_image);
        }

        $securityGuard->delete();

        return redirect()->route('security-guards.index')->with('success', 'Security Guard deleted successfully.');
    }

    /**
     * Generate QR code for a security guard.
     */
    public function generateSecurityGuardQR(SecurityGuard $securityGuard)
    {
        // Create a unique identifier for the security guard
        $data = [
            'type' => 'security_guard',
            'id' => $securityGuard->id,
            'name' => $securityGuard->first_name . ' ' . $securityGuard->last_name,
            'badge_number' => $securityGuard->badge_number,
            'timestamp' => now()->toISOString(),
        ];

        $qrCode = QrCode::size(300)->generate(json_encode($data));

        return Response::make($qrCode, 200, [
            'Content-Type' => 'image/svg+xml'
        ]);
    }
}
