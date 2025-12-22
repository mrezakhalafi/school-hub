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
                        <h1 class="display-6 fw-bold text-dark mb-0">Parents</h1>
                    </div>
                </div>
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('parents.create') }}" class="btn btn-primary">Add New Parent</a>
                @endif
            </div>

            <!-- Summary Cards Row -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card h-100 shadow-lg border-0 bg-gradient-to-br from-blue-50 to-indigo-50">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Father</p>
                                    <h3 class="fw-bold mb-0">{{ $totalFathers }}</h3>
                                </div>
                                <div class="p-3 rounded-circle bg-blue-100 dashboard-card-icon">
                                    <i class="fas fa-male text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 shadow-lg border-0 bg-gradient-to-br from-pink-50 to-rose-50">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Mother</p>
                                    <h3 class="fw-bold mb-0">{{ $totalMothers }}</h3>
                                </div>
                                <div class="p-3 rounded-circle bg-pink-100 dashboard-card-icon">
                                    <i class="fas fa-female text-pink"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 shadow-lg border-0 bg-gradient-to-br from-gray-50 to-slate-50">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Guardian</p>
                                    <h3 class="fw-bold mb-0">{{ $totalGuardians }}</h3>
                                </div>
                                <div class="p-3 rounded-circle bg-gray-100 dashboard-card-icon">
                                    <i class="fas fa-user-shield text-secondary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Form -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('parents.index') }}">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-5">
                                <label for="search" class="form-label">Search</label>
                                <input type="text" name="search" id="search" class="form-control" placeholder="Search by name, email, phone, relationship, or student..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="relationship" class="form-label">Relationship</label>
                                <select name="relationship" id="relationship" class="form-select">
                                    <option value="">All Relationships</option>
                                    @foreach($relationships as $relationshipOption)
                                        <option value="{{ $relationshipOption }}" {{ request('relationship') == $relationshipOption ? 'selected' : '' }}>
                                            {{ ucfirst($relationshipOption) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('parents.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
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
                                    <th>Name</th>
                                    <th>Relationship</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Student</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($parents as $index => $parent)
                                    <tr>
                                        <td>{{ ($parents->currentPage() - 1) * $parents->perPage() + $index + 1 }}</td>
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
                                        <td colspan="7" class="text-center">No parents found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $parents->appends(['search' => request('search'), 'relationship' => request('relationship')])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection