@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="h3 mb-4">Dashboard</h1>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <a href="{{ route('students.index') }}">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title">{{ $studentCount }}</h4>
                                    <p class="card-text">Students</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 mb-3">
                <a href="{{ route('teachers.index') }}">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title">{{ $teacherCount }}</h4>
                                    <p class="card-text">Teachers</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 mb-3">
                <a href="{{ route('classes.index') }}">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title">{{ $classCount }}</h4>
                                    <p class="card-text">Classes</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-school"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 mb-3">
                <a href="{{ route('permission-reports.index') }}">
                    <div class="card text-white bg-secondary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title">{{ $permissionReportCount ?? 0 }}</h4>
                                    <p class="card-text">Permission Reports</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
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

        <!-- Recent Events -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Recent Events</h5>
                    </div>
                    <div class="card-body">
                        @if ($recentEvents->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Date</th>
                                            <th>Location</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentEvents as $event)
                                            <tr>
                                                <td><a href="{{ route('events.show', $event) }}" class="text-decoration-none">{{ $event->title }}</a></td>
                                                <td>{{ $event->start_date->format('M d, Y') }}</td>
                                                <td>{{ $event->location ?: 'N/A' }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $event->event_type === 'academic'
                                                            ? 'primary'
                                                            : ($event->event_type === 'sports'
                                                                ? 'success'
                                                                : ($event->event_type === 'arts'
                                                                    ? 'info'
                                                                    : ($event->event_type === 'extracurricular'
                                                                        ? 'warning'
                                                                        : 'secondary'))) }}">
                                                        {{ ucfirst($event->event_type) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">No recent events available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
