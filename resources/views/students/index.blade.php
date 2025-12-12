@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Students</h1>
                <a href="{{ route('students.create') }}" class="btn btn-primary">Add New Student</a>
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
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Class</th>
                                    <th>Gender</th>
                                    <th>QR Code</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                    <tr>
                                        <td>
                                            @if($student->profile_image)
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
                                        <td>{{ ucfirst($student->gender) }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-secondary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#qrModal"
                                                    data-qrcode="{{ route('students.qr', $student) }}"
                                                    data-name="{{ $student->first_name . ' ' . $student->last_name }}"
                                                    data-type="Student">
                                                Tampilkan QR
                                            </button>
                                        </td>
                                        <td>
                                            <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Are you sure you want to delete this student?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No students found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        {{ $students->links() }}
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
