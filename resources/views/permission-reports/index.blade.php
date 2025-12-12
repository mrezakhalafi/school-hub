@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Permission Reports</h1>
                <a href="{{ route('permission-reports.create') }}" class="btn btn-primary">Add New Permission Report</a>
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
                                        <td>{{ \Carbon\Carbon::parse($report->permission_date)->format('M d, Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($report->permission_time)->format('H:i') }}</td>
                                        <td>{{ Str::limit($report->reason, 50) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $report->status === 'approved' ? 'success' : ($report->status === 'rejected' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($report->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($report->status === 'pending')
                                                <form method="POST" action="{{ route('permission-reports.status.update', $report) }}" class="d-inline">
                                                    @csrf
                                                    @method('POST')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to approve this permission?')">Approve</button>
                                                </form>
                                                <form method="POST" action="{{ route('permission-reports.status.update', $report) }}" class="d-inline">
                                                    @csrf
                                                    @method('POST')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to reject this permission?')">Reject</button>
                                                </form>
                                            @endif
                                            <a href="{{ route('permission-reports.show', $report) }}" class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('permission-reports.edit', $report) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('permission-reports.destroy', $report) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this permission report?')">
                                                    Delete
                                                </button>
                                            </form>
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
                        {{ $permissionReports->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection