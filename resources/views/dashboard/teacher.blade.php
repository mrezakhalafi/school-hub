@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Teacher Dashboard</h1>
        </div>
    </div>

    <!-- Carousel for Promotions -->
    <div class="row mb-4">
        <div class="col-12">
            <div id="schoolPromoCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#schoolPromoCarousel" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#schoolPromoCarousel" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#schoolPromoCarousel" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner rounded">
                    <div class="carousel-item active">
                        <img src="https://picsum.photos/1200/400?random=1"
                            class="d-block w-100" alt="School Promotion">
                        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
                            <h5>Welcome to SchoolHub</h5>
                            <p>Your comprehensive school management platform</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="https://picsum.photos/1200/400?random=2"
                            class="d-block w-100" alt="Events">
                        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
                            <h5>School Events and Activities</h5>
                            <p>Stay updated with the latest school happenings</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="https://picsum.photos/1200/400?random=3"
                            class="d-block w-100" alt="Management">
                        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
                            <h5>Student and Teacher Management</h5>
                            <p>Manage all school personnel efficiently</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#schoolPromoCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#schoolPromoCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <a href="{{ route('events.index') }}">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title">Events</h4>
                                <p class="card-text">View and manage school events</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="{{ route('teachers.index') }}">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title">Teachers</h4>
                                <p class="card-text">View all teachers</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="{{ route('students.index') }}">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title">Students</h4>
                                <p class="card-text">View all students</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Simple Attendance Button for Teachers -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Attendance</h5>
                </div>
                <div class="card-body">
                    <p>Mark your attendance for today:</p>
                    <form method="POST" action="{{ route('attendance.store') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="date" value="{{ date('Y-m-d') }}">
                        <input type="hidden" name="status" value="present">

                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-check-circle"></i> Hadir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection