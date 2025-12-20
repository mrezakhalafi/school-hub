@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <!-- Hero Section -->
        <section class="hero-section bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-5 py-md-5 mb-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <h1 class="display-4 fw-bold mb-4">
                            <span class="text-primary">SchoolHub</span> - Empowering Education for Tomorrow
                        </h1>
                        <p class="lead text-muted mb-5">
                            A comprehensive digital ecosystem connecting students, teachers, parents, and administrators to
                            create exceptional learning experiences.
                        </p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow">
                                Enter Apps
                            </a>
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg px-5 py-3 rounded-pill">
                                    Sign In
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}"
                                    class="btn btn-outline-primary btn-lg px-5 py-3 rounded-pill">
                                    Go to Dashboard
                                </a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-5 py-md-5 mb-5">
            <div class="container mb-5">
                <div class="row mb-6 mb-md-8">
                    <div class="col-12 text-center">
                        <h2 class="display-6 fw-bold mb-3 mb-md-4">Comprehensive School Management</h2>
                        <p class="lead text-muted mb-0">All the tools you need to run an exceptional educational institution
                        </p>
                    </div>
                </div>
                <div class="row g-4 mt-5">
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-lg rounded-3 hover-lift">
                            <div class="card-body p-4 p-md-5 text-center">
                                <div
                                    class="icon-container bg-primary bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3 mb-md-4">
                                    <i class="fas fa-users fa-2x text-primary"></i>
                                </div>
                                <h5 class="fw-bold mb-2 mb-md-3">Student Management</h5>
                                <p class="text-muted mb-0">Effortlessly track student records, grades, and academic progress
                                    with our intuitive interface.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-lg rounded-3 hover-lift">
                            <div class="card-body p-4 p-md-5 text-center">
                                <div
                                    class="icon-container bg-success bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3 mb-md-4">
                                    <i class="fas fa-chalkboard-teacher fa-2x text-success"></i>
                                </div>
                                <h5 class="fw-bold mb-2 mb-md-3">Teacher Portal</h5>
                                <p class="text-muted mb-0">Streamline teaching activities, attendance, grading, and parent
                                    communication in one place.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-lg rounded-3 hover-lift">
                            <div class="card-body p-4 p-md-5 text-center">
                                <div
                                    class="icon-container bg-info bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3 mb-md-4">
                                    <i class="fas fa-calendar-alt fa-2x text-info"></i>
                                </div>
                                <h5 class="fw-bold mb-2 mb-md-3">Event Planning</h5>
                                <p class="text-muted mb-0">Organize school events, activities, and announcements with
                                    integrated calendar systems.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-lg rounded-3 hover-lift">
                            <div class="card-body p-4 p-md-5 text-center">
                                <div
                                    class="icon-container bg-warning bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3 mb-md-4">
                                    <i class="fas fa-user-friends fa-2x text-warning"></i>
                                </div>
                                <h5 class="fw-bold mb-2 mb-md-3">Parent Communication</h5>
                                <p class="text-muted mb-0">Keep families informed with real-time updates, reports, and
                                    communication tools.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-lg rounded-3 hover-lift">
                            <div class="card-body p-4 p-md-5 text-center">
                                <div
                                    class="icon-container bg-danger bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3 mb-md-4">
                                    <i class="fas fa-chart-line fa-2x text-danger"></i>
                                </div>
                                <h5 class="fw-bold mb-2 mb-md-3">Performance Analytics</h5>
                                <p class="text-muted mb-0">Gain insights with comprehensive analytics and reporting for
                                    academic and operational success.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-lg rounded-3 hover-lift">
                            <div class="card-body p-4 p-md-5 text-center">
                                <div
                                    class="icon-container bg-secondary bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3 mb-md-4">
                                    <i class="fas fa-shield-alt fa-2x text-secondary"></i>
                                </div>
                                <h5 class="fw-bold mb-2 mb-md-3">Security & Safety</h5>
                                <p class="text-muted mb-0">Manage campus security staff, access control, and safety
                                    protocols effectively.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Statistics Section -->
        <section class="py-5 py-md-5 bg-light mt-5 mb-5">
            <div class="container">
                <div class="row g-4 mb-5">
                    <div class="col-md-3 col-6 text-center">
                        <div class="stat-card bg-white p-4 rounded-3 shadow-lg">
                            <h3 class="fw-bold text-primary display-5">500+</h3>
                            <p class="mb-0 mt-2">Students</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 text-center">
                        <div class="stat-card bg-white p-4 rounded-3 shadow-lg">
                            <h3 class="fw-bold text-success display-5">25+</h3>
                            <p class="mb-0">Teachers</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 text-center">
                        <div class="stat-card bg-white p-4 rounded-3 shadow-lg">
                            <h3 class="fw-bold text-info display-5">12</h3>
                            <p class="mb-0">Classes</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 text-center">
                        <div class="stat-card bg-white p-4 rounded-3 shadow-lg">
                            <h3 class="fw-bold text-warning display-5">98%</h3>
                            <p class="mb-0">Satisfaction</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="py-8 py-md-12 mt-5 mb-5">
            <div class="container mt-5">
                <div class="row mb-6 mb-md-8">
                    <div class="col-12 text-center">
                        <h2 class="display-6 fw-bold mb-3 mb-md-4">What People Say About Us</h2>
                        <p class="lead text-muted mb-0">Hear from our community members</p>
                    </div>
                </div>
                <div class="row g-4 mt-5">
                    <div class="col-md-4">
                        <div class="testimonial-card card border-0 shadow-lg h-100">
                            <div class="card-body p-4 p-md-5">
                                <div class="rating mb-3">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                                <p class="mb-4">"SchoolHub has transformed how we manage our school operations.
                                    Communication between teachers, students, and parents has never been better."</p>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=Sarah+Johnson&background=3b82f6&color=fff"
                                        class="rounded-circle me-3" width="50" height="50" alt="Sarah Johnson">
                                    <div>
                                        <h6 class="mb-0">Sarah Johnson</h6>
                                        <small class="text-muted">School Principal</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="testimonial-card card border-0 shadow-lg h-100">
                            <div class="card-body p-4 p-md-5">
                                <div class="rating mb-3">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                                <p class="mb-4">"As a teacher, this platform saves me hours each week on administrative
                                    tasks, allowing me to focus more on my students."</p>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=Michael+Chen&background=10b981&color=fff"
                                        class="rounded-circle me-3" width="50" height="50" alt="Michael Chen">
                                    <div>
                                        <h6 class="mb-0">Michael Chen</h6>
                                        <small class="text-muted">Mathematics Teacher</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="testimonial-card card border-0 shadow-lg h-100">
                            <div class="card-body p-4 p-md-5">
                                <div class="rating mb-3">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                </div>
                                <p class="mb-4">"I love staying connected with my child's school through SchoolHub. The
                                    real-time updates keep me informed of his progress."</p>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=Amy+Rodriguez&background=f59e0b&color=fff"
                                        class="rounded-circle me-3" width="50" height="50" alt="Amy Rodriguez">
                                    <div>
                                        <h6 class="mb-0">Amy Rodriguez</h6>
                                        <small class="text-muted">Parent</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-5 py-md-5 bg-gradient-to-r from-blue-600 to-indigo-700 text-white mt-5 mb-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8 text-center text-lg-start mb-4 mb-lg-0">
                        <h2 class="display-6 fw-bold mb-3">Ready to Transform Your School Experience?</h2>
                        <p class="lead mb-0 opacity-90">Join hundreds of schools already benefiting from our comprehensive
                            platform</p>
                    </div>
                    <div class="col-lg-4 text-center text-lg-end">
                        <a href="{{ route('register') }}"
                            class="btn btn-light btn-lg px-5 py-3 rounded-pill fw-semibold shadow">
                            Explore Now
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer CTA -->
        <section class="py-5 py-md-5 mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h3 class="display-6 fw-bold mb-4">Experience the Future of School Management Today</h3>
                        <p class="lead text-muted mb-5">Discover how our platform can revolutionize the way your school
                            operates, learns, and grows.</p>
                        <div class="d-flex flex-wrap justify-content-center gap-3">
                            @guest
                                <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5 py-3 rounded-pill">
                                    Register Now
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg px-5 py-3 rounded-pill">
                                    Sign In
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-5 py-3 rounded-pill">
                                    Go to Dashboard
                                </a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Add custom CSS for modern effects -->
    <style>
        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: scale(1.05);
        }

        .testimonial-card {
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
        }

        .icon-container {
            transition: all 0.3s ease;
        }

        .icon-container:hover {
            transform: scale(1.1);
        }

        .hero-section {
            position: relative;
            overflow: hidden;
        }
    </style>
@endsection
