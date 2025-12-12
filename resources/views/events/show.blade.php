@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Event Details</h1>
                <div>
                    <a href="{{ route('events.index') }}" class="btn btn-secondary">Back to List</a>
                    <a href="{{ route('events.edit', $event) }}" class="btn btn-warning">Edit</a>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" 
                                     alt="Event Image" class="img-fluid rounded">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                     style="height: 300px;">
                                    <i class="fas fa-calendar-alt text-muted" style="font-size: 5rem;"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6">
                            <h2>{{ $event->title }}</h2>
                            
                            <div class="mb-3">
                                <span class="badge bg-{{ $event->event_type === 'academic' ? 'primary' : 
                                       ($event->event_type === 'sports' ? 'success' : 
                                       ($event->event_type === 'arts' ? 'info' : 
                                       ($event->event_type === 'extracurricular' ? 'warning' : 'secondary'))) }} me-2">
                                    {{ ucfirst($event->event_type) }}
                                </span>
                                <span class="badge bg-{{ $event->is_published ? 'success' : 'secondary' }}">
                                    {{ $event->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                            
                            <p class="text-muted"><i class="fas fa-calendar-alt me-2"></i> 
                                {{ $event->start_date->format('M d, Y g:i A') }}
                                @if($event->end_date)
                                    - {{ $event->end_date->format('M d, Y g:i A') }}
                                @endif
                            </p>
                            
                            @if($event->location)
                                <p class="text-muted"><i class="fas fa-map-marker-alt me-2"></i> {{ $event->location }}</p>
                            @endif
                            
                            <p>{{ $event->description ?: 'No description provided.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Delete Button -->
            <div class="mt-4">
                <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" 
                            onclick="return confirm('Are you sure you want to delete this event?')">
                        Delete Event
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection