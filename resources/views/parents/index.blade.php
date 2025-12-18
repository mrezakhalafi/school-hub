@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Parents</h1>
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('parents.create') }}" class="btn btn-primary">Add New Parent</a>
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
                                @forelse($parents as $parent)
                                    <tr>
                                        <td>{{ $parent->first_name }} {{ $parent->last_name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $parent->relationship === 'father' ? 'primary' :
                                                   ($parent->relationship === 'mother' ? 'info' : 'secondary') }}">
                                                {{ ucfirst($parent->relationship) }}
                                            </span>
                                        </td>
                                        <td>{{ $parent->email ?: 'N/A' }}</td>
                                        <td>{{ $parent->phone ?: 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('students.show', $parent->student) }}" class="text-decoration-none">
                                                {{ $parent->student->first_name }} {{ $parent->student->last_name }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('parents.show', $parent) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            @if(Auth::user()->isAdmin())
                                                <a href="{{ route('parents.edit', $parent) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('parents.destroy', $parent) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this parent?')">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No parents found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $parents->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection