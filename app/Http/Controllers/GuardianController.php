<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guardians = Guardian::with('student')->paginate(10);
        return view('guardians.index', compact('guardians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        return view('guardians.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        return view('guardians.show', compact('guardian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guardian $guardian)
    {
        $students = Student::all();
        return view('guardians.edit', compact('guardian', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guardian $guardian)
    {
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
        $guardian->delete();

        return redirect()->route('guardians.index')->with('success', 'Guardian deleted successfully.');
    }
}
