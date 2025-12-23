@extends('layouts.app')

@use('Illuminate\Support\Str')

@section('content')
    <div class="container dashboard-page">
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="display-6 fw-bold text-dark">Welcome, {{ Auth::user()->name }}!</h1>
                    <p class="text-muted">Here's what's happening with your school today.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                        <i class="fas fa-user me-2"></i> Profile
                    </a>
                    @if (Auth::user()->isAdmin())
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-tachometer-alt me-2"></i> Admin Dashboard
                        </a>
                    @endif
                </div>
            </div>

            @if (Auth::user()->isAdmin())
                <!-- Charts Row -->
                <div class="row g-4 mb-5">
                    <div class="col-xl-4">
                        <div class="card shadow-md border-0 h-100">
                            <div class="card-body p-4">
                                <h6 class="card-title mb-4 fw-semibold">
                                    <i class="fas fa-chart-line text-primary me-2"></i>
                                    Student and Teacher Count Over Years
                                </h6>
                                <div style="height: 300px;">
                                    <canvas id="studentCountChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card shadow-md border-0 h-100">
                            <div class="card-body p-4">
                                <h6 class="card-title mb-4 fw-semibold">
                                    <i class="fas fa-chart-pie text-success me-2"></i>
                                    Gender Distribution
                                </h6>
                                <div style="height: 300px;">
                                    <canvas id="genderDistributionChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card shadow-md border-0 h-100">
                            <div class="card-body p-4">
                                <h6 class="card-title mb-4 fw-semibold">
                                    <i class="fas fa-chart-bar text-info me-2"></i>
                                    Student Distribution by Class
                                </h6>
                                <div style="height: 300px;">
                                    <canvas id="studentCountByClassChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Summary Cards Row -->
            <div class="row g-4 mb-5">
                <div class="col-xl-2 col-md-4">
                    <a href="{{ route('students.index') }}" class="text-decoration-none">
                        <div class="card h-100 p-2 shadow-md border-0 bg-gradient-to-br-blue-indigo">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1 fs-6 fw-bold">Students</p>
                                        <h3 class="fw-bold mb-0">{{ $studentCount }}</h3>
                                    </div>
                                    <div class="p-3 rounded-circle bg-blue-100 dashboard-card-icon">
                                        <i class="fas fa-users text-primary-blue"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-2 col-md-4">
                    <a href="{{ route('teachers.index') }}" class="text-decoration-none">
                        <div class="card h-100 p-2 shadow-md border-0 bg-gradient-to-br-green-emerald">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1 fs-6 fw-bold">Teachers</p>
                                        <h3 class="fw-bold mb-0">{{ $teacherCount }}</h3>
                                    </div>
                                    <div class="p-3 rounded-circle bg-green-100 dashboard-card-icon">
                                        <i class="fas fa-chalkboard-teacher text-success-green"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-2 col-md-4">
                    <a href="{{ route('classes.index') }}" class="text-decoration-none">
                        <div class="card h-100 p-2 shadow-md border-0 bg-gradient-to-br-indigo-purple">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1 fs-6 fw-bold">Classes</p>
                                        <h3 class="fw-bold mb-0">{{ $classCount }}</h3>
                                    </div>
                                    <div class="p-3 rounded-circle bg-indigo-100 dashboard-card-icon">
                                        <i class="fas fa-school text-indigo-purple"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-2 col-md-4">
                    <a href="{{ route('permission-reports.index') }}" class="text-decoration-none">
                        <div class="card h-100 p-2 shadow-md border-0 bg-gradient-to-br-orange-amber">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1 fs-6 fw-bold">Permissions</p>
                                        <h3 class="fw-bold mb-0">{{ $permissionReportCount ?? 0 }}</h3>
                                    </div>
                                    <div class="p-3 rounded-circle bg-orange-100 dashboard-card-icon">
                                        <i class="fas fa-file-alt text-warning-orange"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                @if (Auth::user()->isAdmin())
                    <div class="col-xl-2 col-md-4">
                        <a href="{{ route('security-guards.index') }}" class="text-decoration-none">
                            <div class="card h-100 p-2 shadow-md border-0 bg-gradient-to-br-red-pink">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="text-muted mb-1 fs-6 fw-bold">Security</p>
                                            <h3 class="fw-bold mb-0">{{ $securityGuardCount ?? 0 }}</h3>
                                        </div>
                                        <div class="p-3 rounded-circle bg-red-100 dashboard-card-icon">
                                            <i class="fas fa-shield-alt text-danger-red"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xl-2 col-md-4">
                        <a href="{{ route('office-boys.index') }}" class="text-decoration-none">
                            <div class="card h-100 p-2 shadow-md border-0 bg-gradient-to-br-teal-cyan">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="text-muted mb-1 fs-6 fw-bold">Office Staff</p>
                                            <h3 class="fw-bold mb-0">{{ $officeBoyCount ?? 0 }}</h3>
                                        </div>
                                        <div class="p-3 rounded-circle bg-teal-100 dashboard-card-icon">
                                            <i class="fas fa-user-tie text-teal-cyan"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            </div>

            <!-- Second Summary Cards Row -->
            <div class="row g-4 mb-5">
                @if (Auth::user()->isAdmin())
                    <div class="col-xl-2 col-md-4">
                        <a href="{{ route('events.index') }}" class="text-decoration-none">
                            <div class="card h-100 p-2 shadow-md border-0 bg-gradient-to-br-violet-purple">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="text-muted mb-1 fs-6 fw-bold">Events</p>
                                            <h3 class="fw-bold mb-0">{{ $eventCount ?? 0 }}</h3>
                                        </div>
                                        <div class="p-3 rounded-circle bg-violet-100 dashboard-card-icon">
                                            <i class="fas fa-calendar-alt text-violet-purple"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xl-2 col-md-4">
                        <a href="{{ route('parents.index') }}" class="text-decoration-none">
                            <div class="card h-100 p-2 shadow-md border-0 bg-gradient-to-br-slate-gray">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="text-muted mb-1 fs-6 fw-bold">Parents</p>
                                            <h3 class="fw-bold mb-0">{{ $parentCount ?? 0 }}</h3>
                                        </div>
                                        <div class="p-3 rounded-circle bg-gray-100 dashboard-card-icon">
                                            <i class="fas fa-user-friends text-gray-slate"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xl-2 col-md-4">
                        <a href="/classes/1/schedules" class="text-decoration-none">
                            <div class="card h-100 p-2 shadow-md border-0 bg-gradient-to-br-cyan-blue">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="text-muted mb-1 fs-6 fw-bold">Schedules</p>
                                            <h3 class="fw-bold mb-0">{{ $classCount }}</h3>
                                        </div>
                                        <div class="p-3 rounded-circle bg-cyan-100 dashboard-card-icon">
                                            <i class="fas fa-calendar text-primary-blue"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xl-2 col-md-4">
                        <a href="{{ route('attendance.student-dashboard') }}" class="text-decoration-none">
                            <div class="card h-100 p-2 shadow-md border-0 bg-gradient-to-br-amber-yellow">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="text-muted mb-1 fs-6 fw-bold">Attendance</p>
                                            <h3 class="fw-bold mb-0">{{ $attendanceCount ?? 0 }}</h3>
                                        </div>
                                        <div class="p-3 rounded-circle bg-amber-100 dashboard-card-icon">
                                            <i class="fas fa-clipboard-list text-amber-yellow"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xl-2 col-md-4">
                        <a href="{{ route('health-records.index') }}" class="text-decoration-none">
                            <div class="card h-100 p-2 shadow-md border-0 bg-gradient-to-br-pink-rose">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="text-muted mb-1 fs-6 fw-bold">Puskesmas</p>
                                            <h3 class="fw-bold mb-0">{{ $healthRecordCount ?? 0 }}</h3>
                                        </div>
                                        <div class="p-3 rounded-circle bg-pink-100 dashboard-card-icon">
                                            <i class="fas fa-heartbeat text-danger-rose"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xl-2 col-md-4">
                        <a href="{{ route('finance-records.index') }}" class="text-decoration-none">
                            <div class="card h-100 p-2 shadow-md border-0 bg-gradient-to-br-emerald-teal">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="text-muted mb-1 fs-6 fw-bold">Finance</p>
                                            <h3 class="fw-bold mb-0">{{ $financeRecordCount ?? 0 }}</h3>
                                        </div>
                                        <div class="p-3 rounded-circle bg-emerald-100 dashboard-card-icon">
                                            <i class="fas fa-money-bill-wave text-emerald-teal"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            </div>

        </div>

        <!-- Main Content Grid -->
        <div class="row g-4">
            <!-- Recent Events -->
            <div class="col-xl-6">
                <div class="card shadow-md border-0 h-100">
                    <div class="card-header bg-white border-0 py-4 px-4">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-calendar-alt text-primary me-2"></i>
                            Recent Events
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($recentEvents->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Title</th>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentEvents as $index => $event)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <a href="{{ route('events.show', $event) }}"
                                                        class="text-decoration-none fw-medium">
                                                        {{ Str::limit($event->title, 30) }}
                                                    </a>
                                                </td>
                                                <td>{{ $event->start_date->format('M d, Y') }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $event->event_type === 'academic'
                                                            ? 'primary'
                                                            : ($event->event_type === 'sports'
                                                                ? 'success'
                                                                : ($event->event_type === 'arts'
                                                                    ? 'info'
                                                                    : ($event->event_type === 'extracurricular'
                                                                        ? 'warning text-dark'
                                                                        : 'secondary'))) }} rounded-pill px-3 py-2">
                                                        {{ ucfirst($event->event_type) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $event->is_published ? 'success' : 'secondary' }} rounded-pill px-3 py-2">
                                                        {{ $event->is_published ? 'Published' : 'Draft' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-calendar-alt text-muted mb-3 dashboard-card-icon"></i>
                                <p class="text-muted">No recent events available.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Attendance -->
            <div class="col-xl-6">
                <div class="card shadow-md border-0 h-100">
                    <div class="card-header bg-white border-0 py-4 px-4">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-user-check text-success me-2"></i>
                            Recent Attendance
                        </h5>
                    </div>
                    <div class="card-body">
                        @if (isset($recentAttendances) && $recentAttendances->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>User</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Note</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentAttendances as $index => $attendance)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $attendance->user->name }}</td>
                                                <td>
                                                    <span
                                                        class="badge
                                                            @if ($attendance->status == 'present') bg-success
                                                            @elseif($attendance->status == 'absent') bg-danger
                                                            @elseif($attendance->status == 'late') bg-warning text-dark
                                                            @else bg-secondary @endif rounded-pill px-3 py-2">
                                                        {{ ucfirst($attendance->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $attendance->date->format('M d, Y') }}</td>
                                                <td>{{ Str::limit($attendance->note, 20, '...') ?: '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-user-check text-muted mb-3 dashboard-card-icon"></i>
                                <p class="text-muted">No recent attendance records available.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer with application version -->
        <footer class="mt-5 pt-4 border-top text-center text-muted">
            <p class="mb-0">School Hub Application V1.2</p>
        </footer>
    </div>
    </div>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Function to destroy existing chart if it exists
        function destroyChartIfExists(canvasId) {
            const existingChart = Chart.getChart(canvasId);
            if (existingChart) {
                existingChart.destroy();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Line Chart - Student and Teacher Count Over Years
            @if (Auth::user()->isAdmin() && isset($studentCountByYear) && isset($teacherCountByYear))
                const studentCtx = document.getElementById('studentCountChart');
                if (studentCtx) {
                    // Destroy existing chart if it exists to prevent duplicates
                    destroyChartIfExists('studentCountChart');

                    // Prepare data with dummy values for years 2020-2024 and actual data for 2025
                    const allYears = ['2020', '2021', '2022', '2023', '2024', '2025'];
                    const actualStudentData = {!! json_encode($studentCountByYear) !!};
                    const actualTeacherData = {!! json_encode($teacherCountByYear) !!};

                    // Create dataset with dummy values for missing years and actual values for existing years
                    const studentChartData = allYears.map(year => {
                        return actualStudentData[year] || Math.floor(Math.random() * 50) +
                            200; // Random dummy data for missing years
                    });

                    const teacherChartData = allYears.map(year => {
                        return actualTeacherData[year] || Math.floor(Math.random() * 10) +
                            15; // Random dummy data for missing years
                    });

                    const studentChart = new Chart(studentCtx, {
                        type: 'line',
                        data: {
                            labels: allYears,
                            datasets: [{
                                    label: 'Student Count',
                                    data: studentChartData,
                                    borderColor: 'rgb(75, 192, 192)',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    tension: 0.1
                                },
                                {
                                    label: 'Teacher Count',
                                    data: teacherChartData,
                                    borderColor: 'rgb(255, 99, 132)',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    tension: 0.1
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1
                                    }
                                }
                            }
                        }
                    });
                }
            @endif

            // Doughnut Chart - Gender Distribution
            @if (Auth::user()->isAdmin() && isset($genderDistribution) && !empty($genderDistribution))
                const genderCtx = document.getElementById('genderDistributionChart');
                if (genderCtx) {
                    // Destroy existing chart if it exists to prevent duplicates
                    destroyChartIfExists('genderDistributionChart');

                    const genderChart = new Chart(genderCtx, {
                        type: 'doughnut',
                        data: {
                            labels: Object.keys({!! json_encode($genderDistribution) !!}).map(gender =>
                                gender === 'male' ? 'Male' : (gender === 'female' ? 'Female' : gender)
                            ),
                            datasets: [{
                                data: Object.values({!! json_encode($genderDistribution) !!}),
                                backgroundColor: [
                                    'rgb(54, 162, 235)',
                                    'rgb(255, 99, 132)',
                                    'rgb(255, 205, 86)'
                                ],
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                }
            @endif

            // Bar Chart - Student Count by Class
            @if (Auth::user()->isAdmin() && isset($studentCountByClass) && !empty($studentCountByClass))
                const classCtx = document.getElementById('studentCountByClassChart');
                if (classCtx) {
                    // Destroy existing chart if it exists to prevent duplicates
                    destroyChartIfExists('studentCountByClassChart');

                    const classChart = new Chart(classCtx, {
                        type: 'bar',
                        data: {
                            labels: Object.keys({!! json_encode($studentCountByClass) !!}),
                            datasets: [{
                                label: 'Student Count',
                                data: Object.values({!! json_encode($studentCountByClass) !!}),
                                backgroundColor: [
                                    'rgba(54, 162, 235, 0.7)',
                                    'rgba(255, 99, 132, 0.7)',
                                    'rgba(255, 206, 86, 0.7)',
                                    'rgba(75, 192, 192, 0.7)',
                                    'rgba(153, 102, 255, 0.7)',
                                    'rgba(255, 159, 64, 0.7)',
                                    'rgba(255, 99, 132, 0.7)',
                                    'rgba(54, 162, 235, 0.7)',
                                    'rgba(255, 206, 86, 0.7)',
                                    'rgba(75, 192, 192, 0.7)'
                                ],
                                borderColor: [
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)',
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1
                                    }
                                }
                            }
                        }
                    });
                }
            @endif
        });
    </script>
@endsection
