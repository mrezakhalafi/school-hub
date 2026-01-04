<?php

namespace App\Http\Controllers;

use App\Models\SchoolInformation;
use Illuminate\Http\Request;

class SchoolInformationController extends Controller
{
    public function index()
    {
        $schoolInfo = SchoolInformation::first();

        if (!$schoolInfo) {
            // Create a default record if none exists
            $schoolInfo = SchoolInformation::create([
                'school_name' => 'School Name',
                'head_of_school' => 'Head of School',
                'location' => 'School Location',
                'history' => 'School History',
                'building_features' => 'Building Features',
                'extracurricular_activities' => 'Extracurricular Activities',
                'accreditation' => 'A',
                'founding_year' => date('Y'),
                'student_capacity' => 1000,
            ]);
        }

        return view('school-information.edit', compact('schoolInfo'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'school_name' => 'required|string|max:255',
            'head_of_school' => 'required|string|max:255',
            'location' => 'required|string',
            'history' => 'required|string',
            'building_features' => 'required|string',
            'extracurricular_activities' => 'required|string',
            'accreditation' => 'nullable|string|max:10',
            'founding_year' => 'nullable|integer|min:1800|max:2100',
            'student_capacity' => 'nullable|integer|min:0',
        ]);

        $schoolInfo = SchoolInformation::first();

        if (!$schoolInfo) {
            $schoolInfo = SchoolInformation::create($request->all());
        } else {
            $schoolInfo->update($request->all());
        }

        return redirect()->route('school-information.index')->with('success', 'School information updated successfully.');
    }
}
