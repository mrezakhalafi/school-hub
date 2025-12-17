@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Permission Reports</h1>
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('permission-reports.create') }}" class="btn btn-primary">Add New Permission Report</a>
                @endif
            </div>

            <!-- Search and Filter Form -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('permission-reports.index') }}">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label for="search" class="form-label">Search</label>
                                <input type="text" name="search" id="search" class="form-control" placeholder="Search by name or reason..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <label for="permission_type" class="form-label">Type</label>
                                <select name="permission_type" id="permission_type" class="form-select">
                                    <option value="">All Types</option>
                                    @foreach($permissionTypes as $permissionType)
                                        <option value="{{ $permissionType }}" {{ request('permission_type') == $permissionType ? 'selected' : '' }}>
                                            {{ ucfirst($permissionType) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">All Statuses</option>
                                    @foreach($statuses as $statusOption)
                                        <option value="{{ $statusOption }}" {{ request('status') == $statusOption ? 'selected' : '' }}>
                                            {{ ucfirst($statusOption) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="class_id" class="form-label">Class</label>
                                <select name="class_id" id="class_id" class="form-select">
                                    <option value="">All Classes</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
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
                                    <th>Student Name</th>
                                    <th>Class</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($permissionReports as $report)
                                    <tr>
                                        <td>{{ $report->student_name }}</td>
                                        <td>{{ $report->student->class->name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $report->permission_type === 'sick' ? 'danger' : ($report->permission_type === 'event' ? 'info' : ($report->permission_type === 'family' ? 'primary' : 'secondary')) }}">
                                                {{ ucfirst(__($report->permission_type)) }}
                                            </span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($report->permission_date)->format('M d, Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($report->permission_time)->format('H:i') }}</td>
                                        <td>{{ Str::limit($report->reason, 50) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $report->status === 'approved' ? 'success' : ($report->status === 'rejected' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($report->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($report->status === 'pending' && Auth::user()->isAdmin())
                                                <form method="POST" action="{{ route('permission-reports.status.update', $report) }}" class="d-inline">
                                                    @csrf
                                                    @method('POST')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to approve this permission?')">
                                                        <i class="fas fa-check"></i> Approve
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('permission-reports.status.update', $report) }}" class="d-inline">
                                                    @csrf
                                                    @method('POST')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to reject this permission?')">
                                                        <i class="fas fa-times"></i> Reject
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('permission-reports.show', $report) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            @if(Auth::user()->isAdmin())
                                                <a href="{{ route('permission-reports.edit', $report) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('permission-reports.destroy', $report) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this permission report?')">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No permission reports found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $permissionReports->appends(['search' => request('search'), 'permission_type' => request('permission_type'), 'status' => request('status'), 'class_id' => request('class_id')])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection