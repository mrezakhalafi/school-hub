@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Class Details</h1>
                <div>
                    <a href="{{ route('classes.index') }}" class="btn btn-secondary">Back to List</a>
                    <a href="{{ route('classes.edit', $class) }}" class="btn btn-warning">Edit</a>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Class Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>Class Name:</th>
                            <td>{{ $class->name }}</td>
                        </tr>
                        <tr>
                            <th>Level:</th>
                            <td>{{ $class->level }}</td>
                        </tr>
                        <tr>
                            <th>Major:</th>
                            <td>{{ $class->major }}</td>
                        </tr>
                        <tr>
                            <th>Section:</th>
                            <td>{{ $class->section ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Class Advisor:</th>
                            <td>
                                @if($class->advisor)
                                    <a href="{{ route('teachers.show', $class->advisor) }}" class="text-decoration-none">
                                        {{ $class->advisor->first_name }} {{ $class->advisor->last_name }}
                                    </a>
                                @else
                                    <span class="text-muted">Not assigned</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Description:</th>
                            <td>{{ $class->description ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Student Count:</th>
                            <td>{{ $class->students->count() }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <!-- Students Section -->
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Students in this Class</h5>
                    <a href="{{ route('students.create') }}?class_id={{ $class->id }}" class="btn btn-primary btn-sm">
                        Add Student
                    </a>
                </div>
                <div class="card-body">
                    @if($class->students->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($class->students as $student)
                                        <tr>
                                            <td>{{ $student->student_id }}</td>
                                            <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                            <td>{{ ucfirst($student->gender) }}</td>
                                            <td>
                                                <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-info">View</a>
                                                <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-warning">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No students registered in this class.</p>
                        <a href="{{ route('students.create') }}?class_id={{ $class->id }}" class="btn btn-primary">
                            Add Student
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Delete Button -->
            <div class="mt-4">
                <form action="{{ route('classes.destroy', $class) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" 
                            onclick="return confirm('Are you sure you want to delete this class? All associated students will be affected.')">
                        Delete Class
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection