@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Office Boy Details</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($officeBoy->profile_image)
                        <img src="{{ asset('storage/' . $officeBoy->profile_image) }}" alt="Profile" class="img-fluid rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 200px; height: 200px;">
                            <span class="display-4">{{ ucfirst(substr($officeBoy->first_name, 0, 1)) }}</span>
                        </div>
                    @endif
                    <h4>{{ $officeBoy->getFullNameAttribute() }}</h4>
                    <p class="text-muted">{{ $officeBoy->employee_id }}</p>
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
                            <p><strong>Name:</strong> {{ $officeBoy->first_name }} {{ $officeBoy->last_name }}</p>
                            <p><strong>Email:</strong> {{ $officeBoy->email }}</p>
                            <p><strong>Phone:</strong> {{ $officeBoy->phone ?? 'N/A' }}</p>
                            <p><strong>Employee ID:</strong> {{ $officeBoy->employee_id }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Gender:</strong> {{ ucfirst($officeBoy->gender) ?? 'N/A' }}</p>
                            <p><strong>Birth Date:</strong> {{ $officeBoy->birth_date ? $officeBoy->birth_date->format('d M Y') : 'N/A' }}</p>
                            <p><strong>Department:</strong> {{ $officeBoy->department ?? 'N/A' }}</p>
                            <p><strong>Hire Date:</strong> {{ $officeBoy->hire_date ? $officeBoy->hire_date->format('d M Y') : 'N/A' }}</p>
                        </div>
                    </div>
                    <p><strong>Address:</strong> {{ $officeBoy->address ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('office-boys.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to List</a>
                    <a href="{{ route('office-boys.edit', $officeBoy) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                    <a href="{{ route('office-boys.qr', $officeBoy) }}" class="btn btn-primary"><i class="fas fa-qrcode"></i> QR Code</a>
                    <button type="button" class="btn btn-danger" onclick="deleteBoy({{ $officeBoy->id }})"><i class="fas fa-trash"></i> Delete</button>
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