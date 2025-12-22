@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm mb-2 me-3">
                    <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                </a>
                <div class="d-inline-block align-middle">
                    <h1 class="display-6 fw-bold text-dark mb-0">Puskesmas</h1>
                </div>
            </div>
            <a href="{{ route('health-records.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Add New Record
            </a>
        </div>

        <!-- Summary Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card h-100 shadow-lg border-0 bg-gradient-to-br from-blue-50 to-indigo-50">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Total Students</p>
                                <h3 class="fw-bold mb-0">{{ $healthRecords->total() }}</h3>
                            </div>
                            <div class="p-3 rounded-circle bg-blue-100 dashboard-card-icon">
                                <i class="fas fa-users text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card h-100 shadow-lg border-0 bg-gradient-to-br from-green-50 to-emerald-50">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Healthy Students</p>
                                <h3 class="fw-bold mb-0">0</h3>
                            </div>
                            <div class="p-3 rounded-circle bg-green-100 dashboard-card-icon">
                                <i class="fas fa-heart text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card h-100 shadow-lg border-0 bg-gradient-to-br from-red-50 to-pink-50">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Medical Issues</p>
                                <h3 class="fw-bold mb-0">0</h3>
                            </div>
                            <div class="p-3 rounded-circle bg-red-100 dashboard-card-icon">
                                <i class="fas fa-stethoscope text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card h-100 shadow-lg border-0 bg-gradient-to-br from-amber-50 to-yellow-50">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Last Checkup</p>
                                <h3 class="fw-bold mb-0">
                                    {{ $healthRecords->first() ? $healthRecords->first()->created_at->format('M d') : '-' }}
                                </h3>
                            </div>
                            <div class="p-3 rounded-circle bg-amber-100 dashboard-card-icon">
                                <i class="fas fa-calendar-check text-amber"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('health-records.index') }}">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="search"
                                placeholder="Search by student name..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="healthy" {{ request('status') == 'healthy' ? 'selected' : '' }}>Healthy
                                </option>
                                <option value="needs_attention"
                                    {{ request('status') == 'needs_attention' ? 'selected' : '' }}>Needs Attention</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i>
                                Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Health Records Table -->
        <div class="card shadow-lg border-0">
            <div class="card-header bg-white border-0 py-4 px-4">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-file-medical text-info me-2"></i>
                    Health Records
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Student</th>
                                <th>Height</th>
                                <th>Weight</th>
                                <th>Blood Pressure</th>
                                <th>Date Checked</th>
                                <th>Checked By</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($healthRecords as $index => $record)
                                <tr>
                                    <td>{{ ($healthRecords->currentPage() - 1) * $healthRecords->perPage() + $index + 1 }}
                                    </td>
                                    <td>
                                        <a href="{{ route('health-records.show', $record) }}"
                                            class="text-decoration-none fw-medium">
                                            {{ $record->student->first_name ?? '' }}
                                            {{ $record->student->last_name ?? '' }}
                                        </a>
                                    </td>
                                    <td>{{ $record->height ? $record->height . ' cm' : '-' }}</td>
                                    <td>{{ $record->weight ? $record->weight . ' kg' : '-' }}</td>
                                    <td>{{ $record->blood_pressure ?: '-' }}</td>
                                    <td>{{ $record->date_checked ? $record->date_checked->format('M d, Y') : '-' }}</td>
                                    <td>{{ $record->checked_by ?: '-' }}</td>
                                    <td>
                                        @if ($record->medical_conditions && count($record->medical_conditions) > 0)
                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Needs
                                                Attention</span>
                                        @else
                                            <span class="badge bg-success rounded-pill px-3 py-2">Healthy</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item"
                                                        href="{{ route('health-records.show', $record) }}"><i
                                                            class="fas fa-eye me-2"></i> View</a></li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('health-records.edit', $record) }}"><i
                                                            class="fas fa-edit me-2"></i> Edit</a></li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <form method="POST"
                                                        action="{{ route('health-records.destroy', $record) }}"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger"
                                                            onclick="return confirm('Are you sure you want to delete this health record?')">
                                                            <i class="fas fa-trash me-2"></i> Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <i class="fas fa-file-medical text-muted mb-3 dashboard-card-icon"></i>
                                        <p class="text-muted">No health records found.</p>
                                        <a href="{{ route('health-records.create') }}" class="btn btn-primary">Add New
                                            Record</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $healthRecords->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
