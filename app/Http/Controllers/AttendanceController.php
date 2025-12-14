<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|in:present,absent,late',
            'note' => 'nullable|string|max:500',
            'date' => 'required|date',
        ]);

        $user = Auth::user();

        // Check if user is teacher or student to allow attendance submission
        if (!$user->isTeacher() && !$user->isStudent()) {
            return redirect()->back()->withErrors(['error' => 'Only teachers and students can submit attendance.']);
        }

        // Prevent duplicate attendance for the same date
        $existingAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $request->date)
            ->first();

        if ($existingAttendance) {
            return redirect()->back()->withErrors(['error' => 'Attendance already submitted for this date.']);
        }

        Attendance::create([
            'user_id' => $user->id,
            'status' => $request->status,
            'note' => $request->note,
            'date' => $request->date,
        ]);

        return redirect()->back()->with('success', 'Attendance submitted successfully!');
    }
}
