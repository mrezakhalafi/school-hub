<?php

namespace App\Http\Controllers;

use App\Models\SchoolEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
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

        $query = SchoolEvent::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by event type
        if ($request->filled('event_type')) {
            $query->where('event_type', $request->event_type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_published', $request->status === 'published' ? true : false);
        }

        $events = $query->orderBy('start_date', 'desc')->paginate(10);
        $eventTypes = ['academic', 'sports', 'arts', 'extracurricular', 'other'];
        $statuses = ['published', 'draft'];

        return view('events.index', compact('events', 'eventTypes', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorizeResource('write');
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorizeResource('write');
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'event_type' => 'required|in:academic,extracurricular,sports,arts,other',
            'is_published' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $eventData = $request->all();
        $eventData['is_published'] = $request->has('is_published') ? true : false;

        // Handle event image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('events', 'public');
            $eventData['image'] = $path;
        }

        SchoolEvent::create($eventData);

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolEvent $event)
    {
        $this->authorizeResource('read');
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolEvent $event)
    {
        $this->authorizeResource('write');
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolEvent $event)
    {
        $this->authorizeResource('write');
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'event_type' => 'required|in:academic,extracurricular,sports,arts,other',
            'is_published' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $eventData = $request->all();
        $eventData['is_published'] = $request->has('is_published') ? true : false;

        // Handle event image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }

            $path = $request->file('image')->store('events', 'public');
            $eventData['image'] = $path;
        } elseif ($request->has('remove_image') && $request->remove_image) {
            // Remove existing image
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $eventData['image'] = null;
        } else {
            unset($eventData['image']); // Don't update image if not provided
        }

        $event->update($eventData);

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolEvent $event)
    {
        $this->authorizeResource('write');
        // Delete event image if exists
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
