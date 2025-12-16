@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Security Guard Details</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($securityGuard->profile_image)
                        <img src="{{ asset('storage/' . $securityGuard->profile_image) }}" alt="Profile" class="img-fluid rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                    @else
                        <img src="https://picsum.photos/400/400?random={{ $securityGuard->id }}" alt="Profile" class="img-fluid rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                    @endif
                    <h4>{{ $securityGuard->getFullNameAttribute() }}</h4>
                    <p class="text-muted">{{ $securityGuard->badge_number }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Personal Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> {{ $securityGuard->first_name }} {{ $securityGuard->last_name }}</p>
                            <p><strong>Email:</strong> {{ $securityGuard->email }}</p>
                            <p><strong>Phone:</strong> {{ $securityGuard->phone ?? 'N/A' }}</p>
                            <p><strong>Badge Number:</strong> {{ $securityGuard->badge_number }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Gender:</strong> {{ ucfirst($securityGuard->gender) ?? 'N/A' }}</p>
                            <p><strong>Birth Date:</strong> {{ $securityGuard->birth_date ? $securityGuard->birth_date->format('d M Y') : 'N/A' }}</p>
                            <p><strong>Shift:</strong> {{ ucfirst($securityGuard->shift) ?? 'N/A' }}</p>
                            <p><strong>Hire Date:</strong> {{ $securityGuard->hire_date ? $securityGuard->hire_date->format('d M Y') : 'N/A' }}</p>
                        </div>
                    </div>
                    <p><strong>Address:</strong> {{ $securityGuard->address ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('security-guards.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to List</a>
                    <a href="{{ route('security-guards.edit', $securityGuard) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                    <a href="{{ route('security-guards.qr', $securityGuard) }}" class="btn btn-primary"><i class="fas fa-qrcode"></i> QR Code</a>
                    <button type="button" class="btn btn-danger" onclick="deleteGuard({{ $securityGuard->id }})"><i class="fas fa-trash"></i> Delete</button>
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