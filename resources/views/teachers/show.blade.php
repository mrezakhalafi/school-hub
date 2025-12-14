@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Teacher Details</h1>
                <div>
                    <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Back to List</a>
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-warning">Edit</a>
                    @endif
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Teacher Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            @if($teacher->profile_image)
                                <img src="{{ asset('storage/' . $teacher->profile_image) }}"
                                     alt="Profile" class="rounded-circle img-fluid" style="max-width: 200px; height: auto;">
                            @else
                                <img src="https://picsum.photos/400/400?random={{ $teacher->id }}"
                                     class="rounded-circle img-fluid" style="max-width: 200px; height: auto;"
                                     alt="Profile">
                            @endif
                        </div>
                        
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $teacher->first_name }} {{ $teacher->last_name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $teacher->email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{ $teacher->phone ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Birth Date:</th>
                                    <td>{{ $teacher->birth_date ? $teacher->birth_date->format('M d, Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Gender:</th>
                                    <td>{{ ucfirst($teacher->gender) }}</td>
                                </tr>
                                <tr>
                                    <th>Address:</th>
                                    <td>{{ $teacher->address ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Class Advisor:</th>
                                    <td>
                                        @if($teacher->class)
                                            <a href="{{ route('classes.show', $teacher->class) }}" class="text-decoration-none">
                                                {{ $teacher->class->name }}
                                            </a>
                                        @else
                                            <span class="text-muted">Not assigned as class advisor</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Delete Button -->
            @if(Auth::user()->isAdmin())
                <div class="mt-4">
                    <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this teacher?')">
                            Delete Teacher
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection