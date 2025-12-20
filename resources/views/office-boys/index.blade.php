@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Office Boys</h1>
        </div>
    </div>

    <!-- Gender Summary Cards Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card h-100 shadow-lg border-0 bg-gradient-to-br from-cyan-50 to-blue-50">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Male Office Boys</p>
                            <h3 class="fw-bold mb-0">{{ $totalMale }}</h3>
                        </div>
                        <div class="p-3 rounded-circle bg-cyan-100 dashboard-card-icon">
                            <i class="fas fa-mars text-cyan"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100 shadow-lg border-0 bg-gradient-to-br from-pink-50 to-rose-50">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Female Office Boys</p>
                            <h3 class="fw-bold mb-0">{{ $totalFemale }}</h3>
                        </div>
                        <div class="p-3 rounded-circle bg-pink-100 dashboard-card-icon">
                            <i class="fas fa-venus text-pink"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-lg">
                <div class="card-body">
                    <form method="GET" action="{{ route('office-boys.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Search by name, email, ID, or department..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="gender" class="form-select">
                                    <option value="">All Genders</option>
                                    @foreach($genders as $gender)
                                        <option value="{{ $gender }}" {{ request('gender') == $gender ? 'selected' : '' }}>
                                            {{ ucfirst($gender) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="department" class="form-select">
                                    <option value="">All Departments</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>
                                            {{ $dept }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Filter</button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('office-boys.create') }}" class="btn btn-success w-100"><i class="fas fa-plus"></i> Add New</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Office Boys Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Employee ID</th>
                                    <th>Department</th>
                                    <th>Gender</th>
                                    <th>Hire Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($officeBoys as $index => $boy)
                                <tr>
                                    <td>{{ ($officeBoys->currentPage() - 1) * $officeBoys->perPage() + $index + 1 }}</td>
                                    <td>
                                        @if($boy->profile_image)
                                            <img src="{{ asset('storage/' . $boy->profile_image) }}" alt="Profile" width="50" height="50" class="rounded-circle">
                                        @else
                                            <img src="https://picsum.photos/100/100?random={{ $boy->id }}" alt="Profile" width="50" height="50" class="rounded-circle">
                                        @endif
                                    </td>
                                    <td>{{ $boy->first_name }} {{ $boy->last_name }}</td>
                                    <td>{{ $boy->email }}</td>
                                    <td>{{ $boy->employee_id }}</td>
                                    <td><span class="badge bg-secondary">{{ $boy->department }}</span></td>
                                    <td>{{ ucfirst($boy->gender) }}</td>
                                    <td>{{ $boy->hire_date ? $boy->hire_date->format('d M Y') : 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('office-boys.show', $boy) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="{{ route('office-boys.edit', $boy) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="{{ route('office-boys.qr', $boy) }}" class="btn btn-sm btn-primary" title="QR Code">
                                            <i class="fas fa-qrcode"></i> QR
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteBoy({{ $boy->id }})" title="Delete">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <div class="alert alert-info">
                                            No office boys found.
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $officeBoys->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deleteBoy(id) {
    if (confirm('Are you sure you want to delete this office boy?')) {
        // Create a form to submit the delete request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/office-boys/${id}`;
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        const csrfField = document.createElement('input');
        csrfField.type = 'hidden';
        csrfField.name = '_token';
        csrfField.value = '{{ csrf_token() }}';
        
        form.appendChild(methodField);
        form.appendChild(csrfField);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection