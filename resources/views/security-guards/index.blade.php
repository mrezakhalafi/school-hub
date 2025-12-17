@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Security Guards (Satpam)</h1>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('security-guards.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Search by name, email, or badge number..." value="{{ request('search') }}">
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
                                <select name="shift" class="form-select">
                                    <option value="">All Shifts</option>
                                    @foreach($shifts as $shift)
                                        <option value="{{ $shift }}" {{ request('shift') == $shift ? 'selected' : '' }}>
                                            {{ ucfirst($shift) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Filter</button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('security-guards.create') }}" class="btn btn-success w-100"><i class="fas fa-plus"></i> Add New</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Guards Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Badge Number</th>
                                    <th>Shift</th>
                                    <th>Gender</th>
                                    <th>Hire Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($securityGuards as $index => $guard)
                                <tr>
                                    <td>{{ ($securityGuards->currentPage() - 1) * $securityGuards->perPage() + $index + 1 }}</td>
                                    <td>
                                        @if($guard->profile_image)
                                            <img src="{{ asset('storage/' . $guard->profile_image) }}" alt="Profile" width="50" height="50" class="rounded-circle">
                                        @else
                                            <img src="https://picsum.photos/100/100?random={{ $guard->id }}" alt="Profile" width="50" height="50" class="rounded-circle">
                                        @endif
                                    </td>
                                    <td>{{ $guard->first_name }} {{ $guard->last_name }}</td>
                                    <td>{{ $guard->email }}</td>
                                    <td>{{ $guard->badge_number }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($guard->shift == 'morning') bg-success 
                                            @elseif($guard->shift == 'afternoon') bg-warning text-dark 
                                            @else bg-info @endif">
                                            {{ ucfirst($guard->shift) }}
                                        </span>
                                    </td>
                                    <td>{{ ucfirst($guard->gender) }}</td>
                                    <td>{{ $guard->hire_date ? $guard->hire_date->format('d M Y') : 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('security-guards.show', $guard) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="{{ route('security-guards.edit', $guard) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="{{ route('security-guards.qr', $guard) }}" class="btn btn-sm btn-primary" title="QR Code">
                                            <i class="fas fa-qrcode"></i> QR
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteGuard({{ $guard->id }})" title="Delete">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <div class="alert alert-info">
                                            No security guards found.
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $securityGuards->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deleteGuard(id) {
    if (confirm('Are you sure you want to delete this security guard?')) {
        // Create a form to submit the delete request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/security-guards/${id}`;
        
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