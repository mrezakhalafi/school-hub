@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Permission Report Details</h1>
                <div>
                    <a href="{{ route('permission-reports.index') }}" class="btn btn-secondary me-2">Back to List</a>
                    <a href="{{ route('permission-reports.edit', $permissionReport) }}" class="btn btn-warning">Edit</a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Permission Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Student Name:</th>
                                    <td>{{ $permissionReport->student_name }}</td>
                                </tr>
                                <tr>
                                    <th>Class Name:</th>
                                    <td>{{ $permissionReport->student->class->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Date:</th>
                                    <td>{{ \Carbon\Carbon::parse($permissionReport->permission_date)->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Time:</th>
                                    <td>{{ \Carbon\Carbon::parse($permissionReport->permission_time)->format('H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge bg-{{ $permissionReport->status === 'approved' ? 'success' : ($permissionReport->status === 'rejected' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($permissionReport->status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Reason:</h6>
                            <p class="bg-light p-3 rounded">{{ $permissionReport->reason }}</p>
                        </div>
                    </div>
                    
                    <!-- WhatsApp Integration Section -->
                    <div class="mt-4">
                        <h6>Share via WhatsApp:</h6>
                        @if($permissionReport->student && $permissionReport->student->guardians->count() > 0)
                            @foreach($permissionReport->student->guardians as $guardian)
                                @if($guardian->phone)
                                    <a href="https://api.whatsapp.com/send?phone={{ urlencode(str_replace(['+', '-', ' '], '', $guardian->phone)) }}&text={{ urlencode('Pemberitahuan Izin Absensi: Anak Anda ' . $permissionReport->student_name . ' dari kelas ' . ($permissionReport->student->class->name ?? 'N/A') . ' tidak hadir pada tanggal ' . \Carbon\Carbon::parse($permissionReport->permission_date)->format('M d, Y') . ' jam ' . \Carbon\Carbon::parse($permissionReport->permission_time)->format('H:i') . ' dengan alasan: ' . $permissionReport->reason) }}"
                                       target="_blank"
                                       class="btn btn-success btn-sm me-2 mb-2">
                                        <i class="fab fa-whatsapp"></i> Send to {{ $guardian->first_name }}
                                    </a>
                                @endif
                            @endforeach
                        @else
                            <p class="text-muted">No guardians found with phone numbers for this student.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Delete Button -->
            <div class="mt-4">
                <form action="{{ route('permission-reports.destroy', $permissionReport) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Are you sure you want to delete this permission report?')">
                        Delete Permission Report
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection