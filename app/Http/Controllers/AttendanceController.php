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
        try {
            $request->validate([
                'status' => 'required|in:present,absent,late',
                'note' => 'nullable|string|max:500',
                'date' => 'required|date',
            ]);

            $user = Auth::user();

            // Check if user is teacher or student to allow attendance submission
            if (!$user->isTeacher() && !$user->isStudent()) {
                if ($request->ajax() || $request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Only teachers and students can submit attendance.'
                    ], 403);
                }
                return redirect()->back()->withErrors(['error' => 'Only teachers and students can submit attendance.']);
            }

            // Prevent duplicate attendance for the same date
            $existingAttendance = Attendance::where('user_id', $user->id)
                ->whereDate('date', $request->date)
                ->first();

            if ($existingAttendance) {
                if ($request->ajax() || $request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Attendance already submitted for this date.'
                    ], 400);
                }
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
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors for AJAX requests
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e; // Re-throw for normal HTTP requests to show validation errors
        } catch (\Exception $e) {
            // Handle other errors for AJAX requests
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while submitting attendance.'
                ], 500);
            }
            throw $e;
        }
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

    /**
     * Display student attendance dashboard for admin
     */
    public function studentAttendanceDashboard(Request $request)
    {
        // Only admins can access this page
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Access denied.');
        }

        // Build the query with filters
        $query = Attendance::with('user')
            ->whereHas('user', function($query) {
                $query->where('role', 'student');
            });

        // Apply filters based on request parameters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->filled('student_name')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->student_name . '%');
            });
        }

        $attendances = $query->orderBy('date', 'desc')->paginate(15);

        // Calculate summary counts based on the same filters
        $baseQuery = Attendance::whereHas('user', function($query) {
            $query->where('role', 'student');
        });

        if ($request->filled('status')) {
            $baseQuery->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $baseQuery->whereDate('date', $request->date);
        }

        if ($request->filled('student_name')) {
            $baseQuery->whereHas('user', function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->student_name . '%');
            });
        }

        $totalPresent = $baseQuery->where('status', 'present')->count();
        $totalAbsent = $baseQuery->where('status', 'absent')->count();
        $totalLate = $baseQuery->where('status', 'late')->count();
        $totalCount = $baseQuery->count();

        return view('attendance.student-dashboard', compact('attendances', 'totalCount', 'totalPresent', 'totalAbsent', 'totalLate'));
    }
}
