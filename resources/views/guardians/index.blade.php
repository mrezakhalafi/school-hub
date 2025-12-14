@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Guardians</h1>
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('guardians.create') }}" class="btn btn-primary">Add New Guardian</a>
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
                                    <th>Name</th>
                                    <th>Relationship</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Student</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($guardians as $guardian)
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
                                            <a href="{{ route('students.show', $guardian->student) }}" class="text-decoration-none">
                                                {{ $guardian->student->first_name }} {{ $guardian->student->last_name }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('guardians.show', $guardian) }}" class="btn btn-sm btn-info">View</a>
                                            @if(Auth::user()->isAdmin())
                                                <a href="{{ route('guardians.edit', $guardian) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('guardians.destroy', $guardian) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this guardian?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No guardians found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        {{ $guardians->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection