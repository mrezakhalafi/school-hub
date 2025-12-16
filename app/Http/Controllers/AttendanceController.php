<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
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

        $attendance = Attendance::create([
            'user_id' => $user->id,
            'status' => $request->status,
            'note' => $request->note,
            'date' => $request->date,
        ]);

        // Return JSON response if AJAX request, otherwise redirect
        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Attendance submitted successfully!',
                'attendance' => $attendance
            ]);
        }

        return redirect()->back()->with('success', 'Attendance submitted successfully!');
    }

    /**
     * Get attendance records for a specific user
     */
    public function getUserAttendance($userId)
    {
        $authenticatedUser = Auth::user();

        // Check if the authenticated user is requesting their own data or is an admin
        if ($authenticatedUser->id != $userId && !$authenticatedUser->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $attendances = Attendance::where('user_id', $userId)->get();

        // Format the response as an associative array with date as key
        $result = [];
        foreach ($attendances as $attendance) {
            $result[$attendance->date->toDateString()] = [
                'status' => $attendance->status,
                'note' => $attendance->note
            ];
        }

        return response()->json($result);
    }
}
