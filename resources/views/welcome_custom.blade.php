<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SchoolHub') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            scroll-behavior: smooth;
        }

        .navbar {
            transition: all 0.4s;
        }

        .navbar.scrolled {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.95) !important;
        }

        .nav-link {
            font-weight: 600;
            position: relative;
            padding: 0.5rem 1rem !important;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: #3b82f6;
            transition: all 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
            left: 0;
        }

        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #dbeafe 0%, #e0e7ff 25%, #e0e7ff 75%, #f3e8ff 100%);
        }

        .bg-cta-gradient {
            background: linear-gradient(90deg, #2563eb 0%, #4f46e5 100%);
        }

        .section-padding {
            padding: 5rem 0;
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            /* Removed scale transformation */
        }

        .testimonial-card {
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            /* Removed translateY transformation */
        }

        .icon-container {
            transition: all 0.3s ease;
        }

        .icon-container:hover {
            /* Removed scale transformation */
        }

        .footer {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
        }

        .footer a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }

        .footer a:hover {
            color: white;
            text-decoration: underline;
        }

        .btn-school {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-school:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="#home">
                <span class="text-primary">{{ config('app.name', 'School-Hub') }}</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="#testimonials">Testimonials</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="#contact">Contact</a>
                    </li>
                    @guest
                        <li class="nav-item ms-2">
                            <a href="{{ route('register') }}" class="btn btn-primary rounded-5 px-4 py-2">Get Started</a>
                        </li>
                    @else
                        <li class="nav-item ms-2">
                            <a href="{{ route('dashboard') }}" class="btn btn-primary rounded-5 px-4 py-2">Dashboard</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div>
        <!-- Hero Section -->
        <section id="home" class="hero-section bg-gradient-to-br py-5 py-md-5 mb-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <h1 class="display-4 fw-bold mb-4">
                            Empowering Education for Tomorrow
                        </h1>
                        <p class="lead text-muted mb-5">
                            A comprehensive digital ecosystem connecting students, teachers, parents, and administrators
                            to
                            create exceptional learning experiences.
                        </p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="{{ route('register') }}"
                                class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow">
                                Get Started
                            </a>
                            @guest
                                <a href="#features" class="btn btn-outline-primary btn-lg px-5 py-3 rounded-pill">
                                    Explore More
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}"
                                    class="btn btn-outline-primary btn-lg px-5 py-3 rounded-pill">
                                    Go to Dashboard
                                </a>
                            @endguest
                        </div>
                    </div>
                    <div class="col-lg-6 mb-5 mb-lg-0 d-flex justify-content-center">
                        <img src="{{ asset('img/undraw_true-friends_1h3v.svg') }}" class="img-fluid w-75"
                            alt="Hero Image">
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-5 py-md-5 mb-5">
            <div class="container mb-5">
                <div class="row mb-6 mb-md-8">
                    <div class="col-12 text-center">
                        <h2 class="display-6 fw-bold mb-3 mb-md-4">Comprehensive School Management</h2>
                        <p class="lead text-muted mb-0">All the tools you need to run an exceptional educational
                            institution
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
                                <p class="text-muted mb-0">Effortlessly track student records, grades, and academic
                                    progress
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
                                <p class="text-muted mb-0">Streamline teaching activities, attendance, grading, and
                                    parent
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

        <!-- About Section -->
        <section id="about" class="py-5 py-md-5 mb-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <h2 class="display-6 fw-bold mb-4">About SchoolHub</h2>
                        <p class="lead text-muted mb-4">
                            SchoolHub is a revolutionary educational platform designed to transform the way schools
                            operate,
                            teach, and connect with their communities. Our mission is to create seamless experiences
                            that
                            enhance learning outcomes and administrative efficiency.
                        </p>
                        <p class="text-muted mb-4">
                            With over 5 years of experience in educational technology, our team has worked with hundreds
                            of
                            schools worldwide to create a comprehensive solution that addresses the real challenges
                            faced by
                            educators, students, and parents in today's digital age.
                        </p>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Secure & Reliable</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Easy to Use</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>24/7 Support</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card shadow-sm h-100">
                                    <div class="card-body text-center p-4">
                                        <div
                                            class="icon-container bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                            <i class="fas fa-graduation-cap fa-2x text-primary"></i>
                                        </div>
                                        <h4 class="fw-bold">Academic Excellence</h4>
                                        <p class="text-muted">Tools designed to enhance teaching and learning outcomes
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card shadow-sm h-100">
                                    <div class="card-body text-center p-4">
                                        <div
                                            class="icon-container bg-success bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                            <i class="fas fa-users fa-2x text-success"></i>
                                        </div>
                                        <h4 class="fw-bold">Community</h4>
                                        <p class="text-muted">Connect students, teachers, and parents effectively</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card shadow-sm h-100">
                                    <div class="card-body text-center p-4">
                                        <div
                                            class="icon-container bg-info bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                            <i class="fas fa-shield-alt fa-2x text-info"></i>
                                        </div>
                                        <h4 class="fw-bold">Safety First</h4>
                                        <p class="text-muted">Prioritizing student and campus security</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card shadow-sm h-100">
                                    <div class="card-body text-center p-4">
                                        <div
                                            class="icon-container bg-warning bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                            <i class="fas fa-chart-line fa-2x text-warning"></i>
                                        </div>
                                        <h4 class="fw-bold">Analytics</h4>
                                        <p class="text-muted">Data-driven insights for better decisions</p>
                                    </div>
                                </div>
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
        <section id="testimonials" class="py-8 py-md-12 mt-5 mb-5">
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
                                <p class="mb-4">"SchoolHub telah mengubah cara kami mengelola operasional sekolah.
                                    Komunikasi antara guru, siswa, dan orang tua tidak pernah sebaik ini."</p>
                                <div class="d-flex align-items-center">
                                    <img src="https://picsum.photos/50/50" class="rounded-circle me-3" width="50"
                                        height="50" alt="Siti Aminah">
                                    <div>
                                        <h6 class="mb-0">Siti Aminah</h6>
                                        <small class="text-muted">Kepala Sekolah</small>
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
                                <p class="mb-4">"Sebagai guru, platform ini menghemat waktu saya setiap minggu untuk
                                    tugas administratif, sehingga saya bisa lebih fokus pada siswa saya."</p>
                                <div class="d-flex align-items-center">
                                    <img src="https://picsum.photos/50/50" class="rounded-circle me-3" width="50"
                                        height="50" alt="Budi Santoso">
                                    <div>
                                        <h6 class="mb-0">Budi Santoso</h6>
                                        <small class="text-muted">Guru Matematika</small>
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
                                <p class="mb-4">"Saya senang bisa terus terhubung dengan sekolah anak saya melalui
                                    SchoolHub. Pembaruan real-time membuat saya selalu mendapat informasi."</p>
                                <div class="d-flex align-items-center">
                                    <img src="https://picsum.photos/50/50" class="rounded-circle me-3" width="50"
                                        class="rounded-circle me-3" width="50" height="50" alt="Ani Wijaya">
                                    <div>
                                        <h6 class="mb-0">Ani Wijaya</h6>
                                        <small class="text-muted">Orang Tua Murid</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-5 py-md-5 mb-5">
            <div class="container">
                <div class="row mb-6 mb-md-8">
                    <div class="col-12 text-center">
                        <h2 class="display-6 fw-bold mb-3 mb-md-4">Get In Touch</h2>
                        <p class="lead text-muted mb-0">Have questions? We'd love to hear from you</p>
                    </div>
                </div>
                <div class="row g-5 mt-5">
                    <div class="col-lg-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-body p-5">
                                <h3 class="fw-bold mb-4">Send us a message</h3>
                                <form>
                                    <div class="mb-4">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control form-control" id="name"
                                            placeholder="Enter your name">
                                    </div>
                                    <div class="mb-4">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control form-control" id="email"
                                            placeholder="Enter your email">
                                    </div>
                                    <div class="mb-4">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea class="form-control form-control" id="message" rows="4" placeholder="How can we help you?"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary rounded-5 w-100">Send
                                        Message</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-body p-5">
                                <h3 class="fw-bold mb-4">Contact Information</h3>
                                <div class="d-flex align-items-start mb-4">
                                    <div
                                        class="icon-container bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 py-4 me-4">
                                        <i class="fas fa-map-marker-alt fa-lg text-primary"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold">Address</h5>
                                        <p class="text-muted mb-0">Cipinang Elok, Jatinegara<br>DKI Jakarta, 13420</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start mb-4">
                                    <div
                                        class="icon-container bg-success bg-opacity-10 rounded-circle d-inline-flex p-3 py-4 me-4">
                                        <i class="fas fa-phone-alt fa-lg text-success"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold">Phone</h5>
                                        <p class="text-muted mb-0">+62 812-9329-1580<br>Mon-Fri, 9 AM - 5 PM</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start mb-4">
                                    <div
                                        class="icon-container bg-info bg-opacity-10 rounded-circle d-inline-flex p-3 py-4 me-4">
                                        <i class="fas fa-envelope fa-lg text-info"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold">Email</h5>
                                        <p class="text-muted mb-0">mrezakhalafi@gmail.com<br>cs@mrezakhalafi.com</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start">
                                    <div
                                        class="icon-container bg-warning bg-opacity-10 rounded-circle d-inline-flex p-3 py-4 me-4">
                                        <i class="fas fa-clock fa-lg text-warning"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold">Working Hours</h5>
                                        <p class="text-muted mb-0">Monday - Friday: 9:00 AM - 6:00 PM<br>Saturday:
                                            10:00 AM - 2:00 PM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-5 py-md-5 bg-cta-gradient text-white mt-5 mb-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8 text-center text-lg-start mb-4 mb-lg-0">
                        <h2 class="display-6 fw-bold mb-3">Ready to Transform Your School Experience?</h2>
                        <p class="lead mb-0 opacity-90">Join hundreds of schools already benefiting from our
                            comprehensive
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
                                    Get Started
                                </a>
                                <a href="#features" class="btn btn-outline-primary btn-lg px-5 py-3 rounded-pill">
                                    Explore More
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

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-md-4">
                    <h4 class="fw-bold mb-4">{{ config('app.name', 'SchoolHub') }}</h4>
                    <p class="mb-4">
                        Empowering education through innovative technology solutions that connect students, teachers,
                        and parents.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white">
                            <i class="fab fa-facebook-f fa-lg"></i>
                        </a>
                        <a href="#" class="text-white">
                            <i class="fab fa-twitter fa-lg"></i>
                        </a>
                        <a href="#" class="text-white">
                            <i class="fab fa-instagram fa-lg"></i>
                        </a>
                        <a href="#" class="text-white">
                            <i class="fab fa-linkedin-in fa-lg"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-2">
                    <h5 class="fw-bold mb-4">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#home" class="text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="#features" class="text-decoration-none">Features</a></li>
                        <li class="mb-2"><a href="#about" class="text-decoration-none">About</a></li>
                        <li class="mb-2"><a href="#testimonials" class="text-decoration-none">Testimonials</a></li>
                        <li class="mb-2"><a href="#contact" class="text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5 class="fw-bold mb-4">Services</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-decoration-none">Student Management</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none">Teacher Portal</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none">Parent Communication</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-decoration-none">Attendance Tracking</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-decoration-none">Grade Management</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5 class="fw-bold mb-4">Contact Us</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Cipinang Elok, 13420</li>
                        <li class="mb-2"><i class="fas fa-phone-alt me-2"></i> +62 812-9329-1580</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> mrezakhalafi@gmail.com</li>
                        <li class="mb-2"><i class="fas fa-clock me-2"></i> Mon-Fri: 9 AM - 5 PM</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="border-top border-light py-3">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="mb-0">&copy; {{ date('Y') + 1 }} {{ config('app.name', 'SchoolHub') }}. All
                            rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <a href="#" class="text-white text-decoration-none me-3">Privacy Policy</a>
                        <a href="#" class="text-white text-decoration-none me-3">Terms of Service</a>
                        <a href="#" class="text-white text-decoration-none">FAQ</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 80, // Adjust for fixed navbar height
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Navbar background change on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Initialize navbar background state
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            }
        });
    </script>
</body>

</html>
