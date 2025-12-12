@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Teachers</h1>
                <a href="{{ route('teachers.create') }}" class="btn btn-primary">Add New Teacher</a>
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
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Class Advisor</th>
                                    <th>QR Code</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($teachers as $teacher)
                                    <tr>
                                        <td>
                                            @if($teacher->profile_image)
                                                <img src="{{ asset('storage/' . $teacher->profile_image) }}" 
                                                     alt="Profile" class="rounded-circle" width="40" height="40">
                                            @else
                                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <span class="text-white">{{ substr($teacher->first_name, 0, 1) . substr($teacher->last_name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $teacher->first_name }} {{ $teacher->last_name }}</td>
                                        <td>{{ $teacher->email }}</td>
                                        <td>{{ ucfirst($teacher->gender) }}</td>
                                        <td>
                                            @if($teacher->class)
                                                <a href="{{ route('classes.show', $teacher->class) }}" class="text-decoration-none">
                                                    {{ $teacher->class->name }}
                                                </a>
                                            @else
                                                <span class="text-muted">Not assigned</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-secondary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#qrModal"
                                                    data-qrcode="{{ route('teachers.qr', $teacher) }}"
                                                    data-name="{{ $teacher->first_name . ' ' . $teacher->last_name }}"
                                                    data-type="Teacher">
                                                Tampilkan QR
                                            </button>
                                        </td>
                                        <td>
                                            <a href="{{ route('teachers.show', $teacher) }}" class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Are you sure you want to delete this teacher?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No teachers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        {{ $teachers->links() }}
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
            
            qrModal.addEventListener('show.bs.modal', function (event) {
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
