<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuardianController extends Controller
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
    public function index()
    {
        $this->authorizeResource('read');
        $guardians = Guardian::with('student')->paginate(10);
        return view('guardians.index', compact('guardians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorizeResource('write');
        $students = Student::all();
        return view('guardians.create', compact('students'));
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
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'relationship' => 'required|in:father,mother,guardian',
            'student_id' => 'required|exists:students,id',
        ]);

        Guardian::create($request->all());

        return redirect()->route('guardians.index')->with('success', 'Guardian created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Guardian $guardian)
    {
        $this->authorizeResource('read');
        return view('guardians.show', compact('guardian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guardian $guardian)
    {
        $this->authorizeResource('write');
        $students = Student::all();
        return view('guardians.edit', compact('guardian', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guardian $guardian)
    {
        $this->authorizeResource('write');
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'relationship' => 'required|in:father,mother,guardian',
            'student_id' => 'required|exists:students,id',
        ]);

        $guardian->update($request->all());

        return redirect()->route('guardians.index')->with('success', 'Guardian updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guardian $guardian)
    {
        $this->authorizeResource('write');
        $guardian->delete();

        return redirect()->route('guardians.index')->with('success', 'Guardian deleted successfully.');
    }
}
