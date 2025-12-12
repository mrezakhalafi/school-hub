<?php

namespace App\Http\Controllers;

use App\Models\SchoolEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = SchoolEvent::orderBy('start_date', 'desc')->paginate(10);
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolEvent $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolEvent $event)
    {
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
        // Delete event image if exists
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
