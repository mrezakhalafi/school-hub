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
    public function index(Request $request)
    {
        $this->authorizeResource('read');

        $query = ParentModel::with('student');

        // Search functionality
        if ($request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('first_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('last_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('phone', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('relationship', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('student', function($q) use ($searchTerm) {
                      $q->where('first_name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('last_name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('student_id', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }

        // Filter by relationship
        if ($request->relationship) {
            $query->where('relationship', $request->relationship);
        }

        $query->orderBy('id', 'asc');

        // Calculate summary data for the cards
        $totalFathers = ParentModel::where('relationship', 'father')->count();
        $totalMothers = ParentModel::where('relationship', 'mother')->count();
        $totalGuardians = ParentModel::where('relationship', 'guardian')->count();

        $parents = $query->paginate(10);
        $relationships = ['father', 'mother', 'guardian']; // Available relationship options

        return view('parents.index', compact('parents', 'totalFathers', 'totalMothers', 'totalGuardians', 'relationships'));
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
