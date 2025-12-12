@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold">Welcome to SchoolHub</h1>
                <p class="lead">Your comprehensive school management platform</p>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card shadow">
                <div class="card-body p-5 text-center">
                    <p class="card-text">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-4">Go to Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4 me-2">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg px-4">Register</a>
                        @endauth
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">About SchoolHub</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        SchoolHub is a comprehensive school management system designed to streamline educational processes. 
                        Our platform provides tools to manage students, teachers, classes, guardians, and events all in one place.
                    </p>
                    <ul>
                        <li>Student and teacher management</li>
                        <li>Class organization with advisor assignment</li>
                        <li>Guardian contact management</li>
                        <li>Event scheduling and promotion</li>
                        <li>Dashboard with key metrics and information</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection