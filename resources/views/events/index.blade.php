@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Events</h1>
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('events.create') }}" class="btn btn-primary">Add New Event</a>
                @endif
            </div>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Location</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($events as $event)
                                    <tr>
                                        <td>
                                            @if($event->image)
                                                <img src="{{ asset('storage/' . $event->image) }}" 
                                                     alt="Event" class="rounded" width="60" height="40" style="object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                     style="width: 60px; height: 40px;">
                                                    <i class="fas fa-calendar-alt text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $event->title }}</td>
                                        <td>{{ $event->start_date->format('M d, Y') }}<br>
                                            <small class="text-muted">{{ $event->start_date->format('g:i A') }}</small>
                                        </td>
                                        <td>{{ $event->location ?: 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $event->event_type === 'academic' ? 'primary' : 
                                                   ($event->event_type === 'sports' ? 'success' : 
                                                   ($event->event_type === 'arts' ? 'info' : 
                                                   ($event->event_type === 'extracurricular' ? 'warning' : 'secondary'))) }}">
                                                {{ ucfirst($event->event_type) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $event->is_published ? 'success' : 'secondary' }}">
                                                {{ $event->is_published ? 'Published' : 'Draft' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-info">View</a>
                                            @if(Auth::user()->isAdmin())
                                                <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this event?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No events found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        {{ $events->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection