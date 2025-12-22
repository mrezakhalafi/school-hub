@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm mb-2 me-3">
                        <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                    </a>
                    <div class="d-inline-block align-middle">
                        <h1 class="display-6 fw-bold text-dark mb-0">Events</h1>
                    </div>
                </div>
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('events.create') }}" class="btn btn-primary">Add New Event</a>
                @endif
            </div>

            <!-- Search and Filter Form -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('events.index') }}">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label for="search" class="form-label">Search</label>
                                <input type="text" name="search" id="search" class="form-control" placeholder="Search by title, location, or description..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="event_type" class="form-label">Event Type</label>
                                <select name="event_type" id="event_type" class="form-select">
                                    <option value="">All Types</option>
                                    @foreach($eventTypes as $eventType)
                                        <option value="{{ $eventType }}" {{ request('event_type') == $eventType ? 'selected' : '' }}>
                                            {{ ucfirst($eventType) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">All Statuses</option>
                                    @foreach($statuses as $statusOption)
                                        <option value="{{ $statusOption }}" {{ request('status') == $statusOption ? 'selected' : '' }}>
                                            {{ ucfirst($statusOption) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
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
                                    <th>No</th>
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
                                @forelse($events as $index => $event)
                                    <tr>
                                        <td>{{ ($events->currentPage() - 1) * $events->perPage() + $index + 1 }}</td>
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
                                            <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            @if(Auth::user()->isAdmin())
                                                <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this event?')">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No events found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        {{ $events->appends(['search' => request('search'), 'event_type' => request('event_type'), 'status' => request('status')])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection