@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Teachers</h1>
                <a href="{{ route('teachers.create') }}" class="btn btn-primary">Add New Teacher</a>
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
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Class Advisor</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($teachers as $teacher)
                                    <tr>
                                        <td>
                                            @if($teacher->profile_image)
                                                <img src="{{ asset('storage/' . $teacher->profile_image) }}" 
                                                     alt="Profile" class="rounded-circle" width="40" height="40">
                                            @else
                                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <span class="text-white">{{ substr($teacher->first_name, 0, 1) . substr($teacher->last_name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $teacher->first_name }} {{ $teacher->last_name }}</td>
                                        <td>{{ $teacher->email }}</td>
                                        <td>{{ ucfirst($teacher->gender) }}</td>
                                        <td>
                                            @if($teacher->class)
                                                <a href="{{ route('classes.show', $teacher->class) }}" class="text-decoration-none">
                                                    {{ $teacher->class->name }}
                                                </a>
                                            @else
                                                <span class="text-muted">Not assigned</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('teachers.show', $teacher) }}" class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Are you sure you want to delete this teacher?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No teachers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        {{ $teachers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection