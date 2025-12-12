@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Guardian Details</h1>
                <div>
                    <a href="{{ route('guardians.index') }}" class="btn btn-secondary">Back to List</a>
                    <a href="{{ route('guardians.edit', $guardian) }}" class="btn btn-warning">Edit</a>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Guardian Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>Name:</th>
                            <td>{{ $guardian->first_name }} {{ $guardian->last_name }}</td>
                        </tr>
                        <tr>
                            <th>Relationship to Student:</th>
                            <td>
                                <span class="badge bg-{{ $guardian->relationship === 'father' ? 'primary' : 
                                       ($guardian->relationship === 'mother' ? 'info' : 'secondary') }}">
                                    {{ ucfirst($guardian->relationship) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $guardian->email ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td>{{ $guardian->phone ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>{{ $guardian->address ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Student:</th>
                            <td>
                                <a href="{{ route('students.show', $guardian->student) }}" class="text-decoration-none">
                                    {{ $guardian->student->first_name }} {{ $guardian->student->last_name }}
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <!-- Delete Button -->
            <div class="mt-4">
                <form action="{{ route('guardians.destroy', $guardian) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" 
                            onclick="return confirm('Are you sure you want to delete this guardian?')">
                        Delete Guardian
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection