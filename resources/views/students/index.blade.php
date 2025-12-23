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
                            <h1 class="display-6 fw-bold text-dark mb-0">Students</h1>
                        </div>
                    </div>
                    @if (Auth::user()->isAdmin())
                        <a href="{{ route('students.create') }}" class="btn btn-primary">Add New Student</a>
                    @endif
                </div>

                <!-- Summary Cards Row -->
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card h-100 shadow-lg border-0 bg-gradient-to-br from-blue-50 to-indigo-50">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1">IPA Students</p>
                                        <h3 class="fw-bold mb-0">{{ $totalIPA }}</h3>
                                    </div>
                                    <div class="p-3 rounded-circle bg-blue-100 dashboard-card-icon">
                                        <i class="fas fa-flask text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card h-100 shadow-lg border-0 bg-gradient-to-br from-green-50 to-emerald-50">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1">IPS Students</p>
                                        <h3 class="fw-bold mb-0">{{ $totalIPS }}</h3>
                                    </div>
                                    <div class="p-3 rounded-circle bg-green-100 dashboard-card-icon">
                                        <i class="fas fa-chart-line text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card h-100 shadow-lg border-0 bg-gradient-to-br from-cyan-50 to-blue-50">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1">Male Students</p>
                                        <h3 class="fw-bold mb-0">{{ $totalMale }}</h3>
                                    </div>
                                    <div class="p-3 rounded-circle bg-cyan-100 dashboard-card-icon">
                                        <i class="fas fa-mars text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card h-100 shadow-lg border-0 bg-gradient-to-br from-pink-50 to-rose-50">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1">Female Students</p>
                                        <h3 class="fw-bold mb-0">{{ $totalFemale }}</h3>
                                    </div>
                                    <div class="p-3 rounded-circle bg-pink-100 dashboard-card-icon">
                                        <i class="fas fa-venus text-danger"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter Form -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('students.index') }}">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label for="search" class="form-label">Search</label>
                                    <input type="text" name="search" id="search" class="form-control"
                                        placeholder="Search by name, ID, or class..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="class_id" class="form-label">Class</label>
                                    <select name="class_id" id="class_id" class="form-select">
                                        <option value="">All Classes</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}"
                                                {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select name="gender" id="gender" class="form-select">
                                        <option value="">All Genders</option>
                                        @foreach ($genders as $genderOption)
                                            <option value="{{ $genderOption }}"
                                                {{ request('gender') == $genderOption ? 'selected' : '' }}>
                                                {{ ucfirst($genderOption) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                                </div>
                                <div class="col-md-1">
                                    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-lg">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Photo</th>
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <th>Class</th>
                                        <th>Permissions</th>
                                        <th>Gender</th>
                                        <th>QR Code</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($students as $index => $student)
                                        <tr>
                                            <td>{{ ($students->currentPage() - 1) * $students->perPage() + $index + 1 }}
                                            </td>
                                            <td>
                                                @if ($student->profile_image)
                                                    <img src="{{ asset('storage/' . $student->profile_image) }}"
                                                        alt="Profile" class="rounded-circle" width="40" height="40">
                                                @else
                                                    <img src="https://picsum.photos/80/80?random={{ $student->id }}"
                                                        alt="Profile" class="rounded-circle" width="40" height="40">
                                                @endif
                                            </td>
                                            <td>{{ $student->student_id }}</td>
                                            <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                            <td>{{ $student->class ? $student->class->name : 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-primary">
                                                    {{ $student->permission_reports_count }}
                                                </span>
                                            </td>
                                            <td>{{ ucfirst($student->gender) }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-secondary" data-bs-toggle="modal"
                                                    data-bs-target="#qrModal"
                                                    data-qrcode="{{ route('students.qr', $student) }}"
                                                    data-name="{{ $student->first_name . ' ' . $student->last_name }}"
                                                    data-type="Student">
                                                    <i class="fas fa-qrcode"></i> QR
                                                </button>
                                            </td>
                                            <td>
                                                <a href="{{ route('students.show', $student) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                @if (Auth::user()->isAdmin())
                                                    <a href="{{ route('students.edit', $student) }}"
                                                        class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form action="{{ route('students.destroy', $student) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this student?')">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No students found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $students->appends(['search' => request('search'), 'class_id' => request('class_id'), 'gender' => request('gender')])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- QR Code Modal -->
        <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="qrModalLabel">QR Code</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p id="qrEntityName"></p>
                        <div id="qrCodeContainer">
                            <img id="qrCodeImage" src="" alt="QR Code" style="width: 300px; height: 300px;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const qrModal = document.getElementById('qrModal');

                qrModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const qrCodeUrl = button.getAttribute('data-qrcode');
                    const name = button.getAttribute('data-name');
                    const type = button.getAttribute('data-type');

                    document.getElementById('qrEntityName').textContent = type + ': ' + name;

                    // Update the QR code image source
                    document.getElementById('qrCodeImage').src = qrCodeUrl;
                });
            });
        </script>
    @endsection
