@extends('layouts.app')

@use('Illuminate\Support\Str')

@section('content')
    <div class="container dashboard-page">
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="display-6 fw-bold text-primary">Welcome back, {{ Auth::user()->name }}!</h1>
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

            <!-- Summary Cards Row -->
            <div class="row g-4 mb-5">
                <div class="col-xl-2 col-md-4">
                    <a href="{{ route('students.index') }}" class="text-decoration-none">
                        <div class="card h-100 shadow-lg border-0 bg-gradient-to-br-blue-indigo">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1">Students</p>
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
                        <div class="card h-100 shadow-lg border-0 bg-gradient-to-br-green-emerald">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1">Teachers</p>
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
                        <div class="card h-100 shadow-lg border-0 bg-gradient-to-br-indigo-purple">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1">Classes</p>
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
                        <div class="card h-100 shadow-lg border-0 bg-gradient-to-br-orange-amber">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1">Permissions</p>
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
                            <div class="card h-100 shadow-lg border-0 bg-gradient-to-br-red-pink">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="text-muted mb-1">Security</p>
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
                            <div class="card h-100 shadow-lg border-0 bg-gradient-to-br-teal-cyan">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="text-muted mb-1">Office Staff</p>
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
                            <div class="card h-100 shadow-lg border-0 bg-gradient-to-br-violet-purple">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="text-muted mb-1">Events</p>
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
                            <div class="card h-100 shadow-lg border-0 bg-gradient-to-br-slate-gray">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="text-muted mb-1">Parents</p>
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
                            <div class="card h-100 shadow-lg border-0 bg-gradient-to-br-cyan-blue">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="text-muted mb-1">Class Schedules</p>
                                            <h3 class="fw-bold mb-0">View</h3>
                                        </div>
                                        <div class="p-3 rounded-circle bg-cyan-100 dashboard-card-icon">
                                            <i class="fas fa-calendar text-cyan-blue"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xl-2 col-md-4">
                        <a href="{{ route('attendance.student-dashboard') }}" class="text-decoration-none">
                            <div class="card h-100 shadow-lg border-0 bg-gradient-to-br-amber-yellow">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="text-muted mb-1">Student Attendance</p>
                                            <h3 class="fw-bold mb-0">Manage</h3>
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
                            <div class="card h-100 shadow-lg border-0 bg-gradient-to-br-pink-rose">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="text-muted mb-1">Puskesmas Siswa</p>
                                            <h3 class="fw-bold mb-0">{{ $healthRecordCount ?? 0 }}</h3>
                                        </div>
                                        <div class="p-3 rounded-circle bg-pink-100 dashboard-card-icon">
                                            <i class="fas fa-heartbeat text-pink-rose"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xl-2 col-md-4">
                        <a href="{{ route('finance-records.index') }}" class="text-decoration-none">
                            <div class="card h-100 shadow-lg border-0 bg-gradient-to-br-emerald-teal">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="text-muted mb-1">Finance Sekolah</p>
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
                <div class="card shadow-lg border-0 h-100">
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
                                            <th>Title</th>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentEvents as $event)
                                            <tr>
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
                <div class="card shadow-lg border-0 h-100">
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
                                            <th>User</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Note</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentAttendances as $attendance)
                                            <tr>
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
    </div>
    </div>
@endsection
