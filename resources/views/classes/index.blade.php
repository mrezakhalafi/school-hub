@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Classes</h1>
                <a href="{{ route('classes.create') }}" class="btn btn-primary">Add New Class</a>
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
                                    <th>Name</th>
                                    <th>Level</th>
                                    <th>Major</th>
                                    <th>Section</th>
                                    <th>Class Advisor</th>
                                    <th>Student Count</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($classes as $class)
                                    <tr>
                                        <td>{{ $class->name }}</td>
                                        <td>{{ $class->level }}</td>
                                        <td>{{ $class->major }}</td>
                                        <td>{{ $class->section ?: 'N/A' }}</td>
                                        <td>
                                            @if($class->advisor)
                                                <a href="{{ route('teachers.show', $class->advisor) }}" class="text-decoration-none">
                                                    {{ $class->advisor->first_name }} {{ $class->advisor->last_name }}
                                                </a>
                                            @else
                                                <span class="text-muted">Not assigned</span>
                                            @endif
                                        </td>
                                        <td>{{ $class->students->count() }}</td>
                                        <td>
                                            <a href="{{ route('classes.show', $class) }}" class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('classes.edit', $class) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('classes.destroy', $class) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Are you sure you want to delete this class? All associated students will be affected.')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No classes found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        {{ $classes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection