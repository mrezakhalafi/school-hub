<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\ClassModel;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
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
     * Display a listing of the resource for a specific class.
     */
    public function index(Request $request, $classId)
    {
        $this->authorizeResource('read');

        $class = ClassModel::findOrFail($classId);
        $allClasses = ClassModel::all(); // Fetch all classes for the dropdown

        // Get all schedules for this class
        $schedules = Schedule::where('class_id', $classId)
            ->orderBy('day')
            ->orderBy('hour')
            ->get();

        // Define the days of the week and hours
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $hours = range(7, 14); // Hours from 7 to 14 (2 PM)

        // Create a structured array for the schedule grid
        $scheduleGrid = [];
        foreach ($days as $day) {
            foreach ($hours as $hour) {
                $scheduleGrid[$day][$hour] = null;
            }
        }

        // Fill the schedule grid with actual schedules
        foreach ($schedules as $schedule) {
            $scheduleGrid[$schedule->day][$schedule->hour] = $schedule;
        }

        return view('schedules.index', compact('class', 'scheduleGrid', 'days', 'hours', 'allClasses'));
    }

    /**
     * Show the form for creating a new schedule.
     */
    public function create($classId)
    {
        $this->authorizeResource('write');

        $class = ClassModel::findOrFail($classId);
        $teachers = Teacher::all();

        // Define days and hours
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $hours = range(7, 14);

        return view('schedules.create', compact('class', 'teachers', 'days', 'hours'));
    }

    /**
     * Store a newly created schedule in storage.
     */
    public function store(Request $request, $classId)
    {
        $this->authorizeResource('write');

        $request->validate([
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday',
            'hour' => 'required|integer|min:7|max:14',
            'subject' => 'required|string|max:255',
            'teacher_id' => 'nullable|exists:teachers,id',
        ]);

        // Check if a schedule already exists for this class, day, and hour
        $existingSchedule = Schedule::where('class_id', $classId)
            ->where('day', $request->day)
            ->where('hour', $request->hour)
            ->first();

        if ($existingSchedule) {
            return redirect()->back()->withErrors(['error' => 'A schedule already exists for this day and hour.']);
        }

        Schedule::create([
            'class_id' => $classId,
            'day' => $request->day,
            'hour' => $request->hour,
            'subject' => $request->subject,
            'teacher_id' => $request->teacher_id,
        ]);

        return redirect()->route('classes.show', $classId)->with('success', 'Schedule created successfully.');
    }

    /**
     * Show the form for editing the specified schedule.
     */
    public function edit($classId, Schedule $schedule)
    {
        $this->authorizeResource('write');

        // Verify that the schedule belongs to the correct class
        if ($schedule->class_id !== (int)$classId) {
            abort(404);
        }

        $class = ClassModel::findOrFail($classId);
        $teachers = Teacher::all();

        // Define days and hours
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $hours = range(7, 14);

        return view('schedules.edit', compact('class', 'schedule', 'teachers', 'days', 'hours'));
    }

    /**
     * Update the specified schedule in storage.
     */
    public function update(Request $request, $classId, Schedule $schedule)
    {
        $this->authorizeResource('write');

        // Verify that the schedule belongs to the correct class
        if ($schedule->class_id !== (int)$classId) {
            abort(404);
        }

        $request->validate([
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday',
            'hour' => 'required|integer|min:7|max:14',
            'subject' => 'required|string|max:255',
            'teacher_id' => 'nullable|exists:teachers,id',
        ]);

        $schedule->update([
            'day' => $request->day,
            'hour' => $request->hour,
            'subject' => $request->subject,
            'teacher_id' => $request->teacher_id,
        ]);

        return redirect()->route('classes.show', $classId)->with('success', 'Schedule updated successfully.');
    }

    /**
     * Remove the specified schedule from storage.
     */
    public function destroy($classId, Schedule $schedule)
    {
        $this->authorizeResource('write');

        // Verify that the schedule belongs to the correct class
        if ($schedule->class_id !== (int)$classId) {
            abort(404);
        }

        $schedule->delete();

        return redirect()->route('classes.show', $classId)->with('success', 'Schedule deleted successfully.');
    }
}
