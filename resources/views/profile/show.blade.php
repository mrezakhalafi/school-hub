@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Profile Information</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <!-- Profile Information -->
                    <div class="row mb-4">
                        <div class="col-md-4 text-center">
                            @if(Auth::user()->profile_image)
                                <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 150px; height: 150px;">
                                    <span class="display-4">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                </div>
                            @endif
                            <h4>{{ Auth::user()->name }}</h4>
                            <span class="badge bg-primary">{{ ucfirst(Auth::user()->role) }}</span>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                                    <p><strong>Role:</strong> {{ ucfirst(Auth::user()->role) }}</p>
                                    @if(Auth::user()->email_verified_at)
                                        <p><strong>Email Verified:</strong> <span class="badge bg-success">Yes</span></p>
                                    @else
                                        <p><strong>Email Verified:</strong> <span class="badge bg-warning">No</span></p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Member Since:</strong> {{ Auth::user()->created_at->format('d M Y') }}</p>
                                    <p><strong>Last Updated:</strong> {{ Auth::user()->updated_at->format('d M Y') }}</p>
                                    @if(Auth::user()->isTeacher())
                                        <p><strong>Class Teacher:</strong> 
                                            @if(Auth::user()->teacher && Auth::user()->teacher->class)
                                                {{ Auth::user()->teacher->class->name }}
                                            @else
                                                <span class="text-muted">Not assigned</span>
                                            @endif
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection