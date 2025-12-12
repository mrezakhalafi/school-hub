<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = ClassModel::with('advisor')->paginate(10);
        return view('classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = Teacher::all();
        return view('classes.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:10',
            'major' => 'required|string|max:10',
            'section' => 'nullable|string|max:10',
            'teacher_id' => 'nullable|exists:teachers,id',
            'description' => 'nullable|string',
        ]);

        ClassModel::create($request->all());

        return redirect()->route('classes.index')->with('success', 'Class created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassModel $class)
    {
        $class->load('advisor', 'students');
        return view('classes.show', compact('class'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassModel $class)
    {
        $teachers = Teacher::all();
        return view('classes.edit', compact('class', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClassModel $class)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:10',
            'major' => 'required|string|max:10',
            'section' => 'nullable|string|max:10',
            'teacher_id' => 'nullable|exists:teachers,id',
            'description' => 'nullable|string',
        ]);

        $class->update($request->all());

        return redirect()->route('classes.index')->with('success', 'Class updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassModel $class)
    {
        $class->delete();

        return redirect()->route('classes.index')->with('success', 'Class deleted successfully.');
    }
}
