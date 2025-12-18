<?php

namespace App\Http\Controllers;

use App\Models\ParentModel;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentController extends Controller
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
        $parents = ParentModel::with('student')->paginate(10);
        return view('parents.index', compact('parents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorizeResource('write');
        $students = Student::all();
        return view('parents.create', compact('students'));
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
            'relationship' => 'required|in:father,mother,parent',
            'student_id' => 'required|exists:students,id',
        ]);

        ParentModel::create($request->all());

        return redirect()->route('parents.index')->with('success', 'Parent created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ParentModel $parent)
    {
        $this->authorizeResource('read');
        return view('parents.show', compact('parent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ParentModel $parent)
    {
        $this->authorizeResource('write');
        $students = Student::all();
        return view('parents.edit', compact('parent', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ParentModel $parent)
    {
        $this->authorizeResource('write');
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'relationship' => 'required|in:father,mother,parent',
            'student_id' => 'required|exists:students,id',
        ]);

        $parent->update($request->all());

        return redirect()->route('parents.index')->with('success', 'Parent updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParentModel $parent)
    {
        $this->authorizeResource('write');
        $parent->delete();

        return redirect()->route('parents.index')->with('success', 'Parent deleted successfully.');
    }
}
