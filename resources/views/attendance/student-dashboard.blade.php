@extends('layouts.app')

@section('content')
<div class="container dashboard-page">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Student Attendance Records</h1>
            </div>
        </div>
    </div>

    <!-- Summary Cards Row -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-lg border-0 bg-gradient-to-br from-blue-50 to-indigo-50">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Records</p>
                            <h3 class="fw-bold mb-0">{{ $totalCount }}</h3>
                        </div>
                        <div class="p-3 rounded-circle bg-blue-100 dashboard-card-icon">
                            <i class="fas fa-clipboard-list text-primary"></i>
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
                            <p class="text-muted mb-1">Present</p>
                            <h3 class="fw-bold mb-0">{{ $totalPresent }}</h3>
                        </div>
                        <div class="p-3 rounded-circle bg-green-100 dashboard-card-icon">
                            <i class="fas fa-check-circle text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-lg border-0 bg-gradient-to-br from-orange-50 to-amber-50">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Absent</p>
                            <h3 class="fw-bold mb-0">{{ $totalAbsent }}</h3>
                        </div>
                        <div class="p-3 rounded-circle bg-orange-100 dashboard-card-icon">
                            <i class="fas fa-times-circle text-warning"></i>
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
                            <p class="text-muted mb-1">Late</p>
                            <h3 class="fw-bold mb-0">{{ $totalLate }}</h3>
                        </div>
                        <div class="p-3 rounded-circle bg-red-100 dashboard-card-icon">
                            <i class="fas fa-clock text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card shadow-lg mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('attendance.student-dashboard') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">All Statuses</option>
                            <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Present</option>
                            <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                            <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Late</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="student_name" class="form-label">Student Name</label>
                        <input type="text" name="student_name" id="student_name" class="form-control" placeholder="Search by student name..." value="{{ request('student_name') }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Student Attendance Table -->
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Student ID</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Note</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->user->name ?? 'N/A' }}</td>
                            <td>{{ $attendance->user->student_id ?? 'N/A' }}</td>
                            <td>{{ $attendance->date->format('M d, Y') }}</td>
                            <td>
                                <span class="badge
                                    @if($attendance->status == 'present') bg-success
                                    @elseif($attendance->status == 'absent') bg-danger
                                    @elseif($attendance->status == 'late') bg-warning text-dark
                                    @endif rounded-pill px-3 py-2">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </td>
                            <td>{{ $attendance->note ?: '-' }}</td>
                            <td>
                                <a href="{{ route('students.show', $attendance->user) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-clipboard-list text-muted mb-3 dashboard-card-icon"></i>
                                <p class="text-muted">No attendance records found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $attendances->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection