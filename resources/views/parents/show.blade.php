@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Parent Details</h1>
                <div>
                    <a href="{{ route('parents.index') }}" class="btn btn-secondary">Back to List</a>
                    <a href="{{ route('parents.edit', $parent) }}" class="btn btn-warning">Edit</a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Parent Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>Name:</th>
                            <td>{{ $parent->first_name }} {{ $parent->last_name }}</td>
                        </tr>
                        <tr>
                            <th>Relationship to Student:</th>
                            <td>
                                <span class="badge bg-{{ $parent->relationship === 'father' ? 'primary' :
                                       ($parent->relationship === 'mother' ? 'info' : 'secondary') }}">
                                    {{ ucfirst($parent->relationship) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $parent->email ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td>{{ $parent->phone ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>{{ $parent->address ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Student:</th>
                            <td>
                                <a href="{{ route('students.show', $parent->student) }}" class="text-decoration-none">
                                    {{ $parent->student->first_name }} {{ $parent->student->last_name }}
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Delete Button -->
            <div class="mt-4">
                <form action="{{ route('parents.destroy', $parent) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Are you sure you want to delete this parent?')">
                        Delete Parent
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection