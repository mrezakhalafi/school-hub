@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Student Details</h1>
                <div>
                    <a href="{{ route('students.index') }}" class="btn btn-secondary">Back to List</a>
                    <a href="{{ route('students.edit', $student) }}" class="btn btn-warning">Edit</a>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Student Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            @if($student->profile_image)
                                <img src="{{ asset('storage/' . $student->profile_image) }}" 
                                     alt="Profile" class="rounded-circle img-fluid" style="max-width: 200px; height: auto;">
                            @else
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                                     style="width: 200px; height: 200px;">
                                    <span class="text-white display-4">{{ substr($student->first_name, 0, 1) . substr($student->last_name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Student ID:</th>
                                    <td>{{ $student->student_id }}</td>
                                </tr>
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                </tr>
                                <tr>
                                    <th>Class:</th>
                                    <td>{{ $student->class ? $student->class->name : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Birth Date:</th>
                                    <td>{{ $student->birth_date ? $student->birth_date->format('M d, Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Gender:</th>
                                    <td>{{ ucfirst($student->gender) }}</td>
                                </tr>
                                <tr>
                                    <th>Address:</th>
                                    <td>{{ $student->address ?: 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Guardians Section -->
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Guardians</h5>
                    <a href="{{ route('guardians.create') }}?student_id={{ $student->id }}" class="btn btn-primary btn-sm">
                        Add Guardian
                    </a>
                </div>
                <div class="card-body">
                    @if($student->guardians->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Relationship</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($student->guardians as $guardian)
                                        <tr>
                                            <td>{{ $guardian->first_name }} {{ $guardian->last_name }}</td>
                                            <td>
                                                <span class="badge bg-{{ $guardian->relationship === 'father' ? 'primary' : 
                                                       ($guardian->relationship === 'mother' ? 'info' : 'secondary') }}">
                                                    {{ ucfirst($guardian->relationship) }}
                                                </span>
                                            </td>
                                            <td>{{ $guardian->email ?: 'N/A' }}</td>
                                            <td>{{ $guardian->phone ?: 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('guardians.show', $guardian) }}" class="btn btn-sm btn-info">View</a>
                                                <a href="{{ route('guardians.edit', $guardian) }}" class="btn btn-sm btn-warning">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No guardians registered for this student.</p>
                        <a href="{{ route('guardians.create') }}?student_id={{ $student->id }}" class="btn btn-primary">
                            Add Guardian
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Delete Button -->
            <div class="mt-4">
                <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" 
                            onclick="return confirm('Are you sure you want to delete this student? All associated guardians will also be removed.')">
                        Delete Student
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection