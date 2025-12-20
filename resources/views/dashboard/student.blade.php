@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="display-6 fw-bold text-primary">Welcome back, {{ Auth::user()->name }}!</h1>
                    <p class="text-muted">Check your school activities and events.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                        <i class="fas fa-user me-2"></i> Profile
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                </div>
            </div>

            <!-- Menu Cards Row -->
            <div class="row g-4 mb-5">
                <div class="col-xl-4 col-md-6">
                    <a href="{{ route('events.index') }}" class="text-decoration-none">
                        <div class="card h-100 shadow-lg border-0 bg-gradient-to-br from-blue-50 to-indigo-50">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="fw-bold mb-1 text-primary">Events</h3>
                                        <p class="text-muted mb-0">View school events and activities</p>
                                    </div>
                                    <div class="p-3 rounded-circle bg-blue-100 dashboard-card-icon">
                                        <i class="fas fa-calendar-alt text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-4 col-md-6">
                    <a href="{{ route('teachers.index') }}" class="text-decoration-none">
                        <div class="card h-100 shadow-lg border-0 bg-gradient-to-br from-green-50 to-emerald-50">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="fw-bold mb-1 text-success">Teachers</h3>
                                        <p class="text-muted mb-0">View your teachers and class advisors</p>
                                    </div>
                                    <div class="p-3 rounded-circle bg-green-100 dashboard-card-icon">
                                        <i class="fas fa-chalkboard-teacher text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>


                <div class="col-xl-4 col-md-6">
                    <a href="{{ route('students.index') }}" class="text-decoration-none">
                        <div class="card h-100 shadow-lg border-0 bg-gradient-to-br from-purple-50 to-violet-50">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="fw-bold mb-1 text-purple">Classmates</h3>
                                        <p class="text-muted mb-0">View your class and classmates</p>
                                    </div>
                                    <div class="p-3 rounded-circle bg-purple-100 dashboard-card-icon">
                                        <i class="fas fa-users text-purple"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="row g-4">
                <!-- Attendance Calendar -->
                <div class="col-xl-8">
                    <div class="card shadow-lg border-0 h-100">
                        <div class="card-header bg-white border-0 py-4 px-4">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-calendar-alt text-success me-2"></i>
                                Attendance Calendar
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="calendar-container">
                                <div class="calendar-header d-flex justify-content-between align-items-center mb-3">
                                    <button class="btn btn-outline-secondary rounded-circle" id="prev-month">
                                        <i class="fas fa-chevron-left dashboard-card-icon"></i>
                                    </button>
                                    <h4 id="current-month-year" class="h5 mb-0">{{ now()->isoFormat('MMMM YYYY') }}</h4>
                                    <button class="btn btn-outline-secondary rounded-circle" id="next-month">
                                        <i class="fas fa-chevron-right dashboard-card-icon"></i>
                                    </button>
                                </div>

                                <div class="weekdays row g-1 mb-2">
                                    <div class="col text-center py-2 fw-medium text-muted">Sun</div>
                                    <div class="col text-center py-2 fw-medium text-muted">Mon</div>
                                    <div class="col text-center py-2 fw-medium text-muted">Tue</div>
                                    <div class="col text-center py-2 fw-medium text-muted">Wed</div>
                                    <div class="col text-center py-2 fw-medium text-muted">Thu</div>
                                    <div class="col text-center py-2 fw-medium text-muted">Fri</div>
                                    <div class="col text-center py-2 fw-medium text-muted">Sat</div>
                                </div>

                                <div id="calendar-days" class="row g-1">
                                    <!-- Calendar days will be populated dynamically -->
                                </div>
                            </div>

                            <div class="mt-3 d-flex justify-content-center">
                                <button type="button" class="btn btn-success px-4 py-2" id="mark-today-attendance">
                                    <i class="fas fa-check-circle me-2 dashboard-card-icon"></i> Mark Today's Attendance
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Summary -->
                <div class="col-xl-4">
                    <div class="card shadow-lg border-0 h-100">
                        <div class="card-header bg-white border-0 py-4 px-4">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-chart-bar text-primary me-2"></i>
                                Attendance Summary
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="attendance-stats">
                                <h6 class="fw-bold text-muted mb-3">This Month</h6>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-medium">Present</span>
                                            <span class="badge bg-success rounded-pill px-3 py-2" id="present-count">0</span>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-medium">Absent</span>
                                            <span class="badge bg-danger rounded-pill px-3 py-2" id="absent-count">0</span>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 0%"></div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-medium">Late</span>
                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2" id="late-count">0</span>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div>
                                <h6 class="fw-bold text-muted mb-3">Legend</h6>
                                <div class="d-flex flex-column gap-3">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-success me-3" style="width: 12px; height: 12px;"></div>
                                        <span class="text-muted">Present</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-danger me-3" style="width: 12px; height: 12px;"></div>
                                        <span class="text-muted">Absent</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-warning me-3" style="width: 12px; height: 12px;"></div>
                                        <span class="text-muted">Late</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-info me-3" style="width: 12px; height: 12px;"></div>
                                        <span class="text-muted">Today</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Modal -->
    <div class="modal fade" id="attendanceModal" tabindex="-1" aria-labelledby="attendanceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="attendanceModalLabel">Mark Attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="attendance-form">
                        <div class="mb-4">
                            <label for="date" class="form-label fw-medium">Date</label>
                            <input type="date" class="form-control form-control-lg" id="date" name="date" required>
                        </div>
                        <div class="mb-4">
                            <label for="status" class="form-label fw-medium">Status</label>
                            <select class="form-select form-select-lg" id="status" name="status" required>
                                <option value="present">Present</option>
                                <option value="absent">Absent</option>
                                <option value="late">Late</option>
                            </select>
                        </div>
                        <div class="mb-0">
                            <label for="note" class="form-label fw-medium">Note (optional)</label>
                            <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success px-4" id="submit-attendance">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .calendar-container {
            background: #f8fafc;
            border-radius: 16px;
            padding: 1rem;
        }

        .calendar-day {
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .calendar-day:hover {
            background-color: #e2e8f0;
            transform: scale(1.05);
        }

        .calendar-day.other-month {
            background-color: #f1f5f9;
            color: #94a3b8;
        }

        .calendar-day.past-day {
            opacity: 0.8;
        }

        .calendar-day.today {
            background-color: #dbeafe;
            border: 2px solid #3b82f6;
            font-weight: bold;
        }

        .calendar-day.attendance-present {
            background-color: #dcfce7;
            border: 1px solid #86efac;
        }

        .calendar-day.attendance-absent {
            background-color: #fee2e2;
            border: 1px solid #fca5a5;
        }

        .calendar-day.attendance-late {
            background-color: #fef3c7;
            border: 1px solid #fde68a;
        }

        .progress {
            border-radius: 10px;
            overflow: hidden;
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const userId = {{ Auth::id() }};
        const today = new Date();
        let currentMonth = new Date(today.getFullYear(), today.getMonth(), 1);

        // Load attendance data
        let attendanceData = {};

        // Fetch attendance data via AJAX
        function loadAttendanceData() {
            fetch(`{{ route('user.attendances.api', ['user' => Auth::id()]) }}`)
                .then(response => response.json())
                .then(data => {
                    attendanceData = data;
                    renderCalendar(currentMonth);
                    updateAttendanceStats();
                })
                .catch(error => console.error('Error loading attendance:', error));
        }

        // Render calendar function
        function renderCalendar(date) {
            const year = date.getFullYear();
            const month = date.getMonth();

            // Set month/year header
            const monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"];
            document.getElementById('current-month-year').textContent = `${monthNames[month]} ${year}`;

            // Get first day of month and last day of month
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            // Clear existing calendar days
            const calendarDaysElement = document.getElementById('calendar-days');
            calendarDaysElement.innerHTML = '';

            // Get previous month details
            const prevMonthDays = new Date(year, month, 0).getDate();

            // Create previous month's days
            for (let i = 0; i < firstDay; i++) {
                const dayElement = document.createElement('div');
                dayElement.className = 'col calendar-day other-month past-day';
                dayElement.textContent = prevMonthDays - firstDay + i + 1;
                calendarDaysElement.appendChild(dayElement);
            }

            // Create current month's days
            const todayDate = today.getDate();
            const todayMonth = today.getMonth();
            const todayYear = today.getFullYear();

            for (let day = 1; day <= daysInMonth; day++) {
                const dayDate = new Date(year, month, day);
                const dayDateString = dayDate.toISOString().split('T')[0];

                const dayElement = document.createElement('div');
                dayElement.className = 'col calendar-day';
                dayElement.textContent = day;

                // Check if this is today
                if (day === todayDate && month === todayMonth && year === todayYear) {
                    dayElement.classList.add('today');
                } else if (dayDate < today) {
                    dayElement.classList.add('past-day');
                }

                // Add attendance status if exists
                if (attendanceData[dayDateString]) {
                    dayElement.classList.add(`attendance-${attendanceData[dayDateString].status}`);

                    // Add tooltip with status and note
                    dayElement.title = `${attendanceData[dayDateString].status.charAt(0).toUpperCase() + attendanceData[dayDateString].status.slice(1)}`;
                    if (attendanceData[dayDateString].note) {
                        dayElement.title += `: ${attendanceData[dayDateString].note}`;
                    }
                }

                // Add click event to mark attendance
                dayElement.addEventListener('click', function() {
                    if (dayDate <= today) {
                        document.getElementById('date').value = dayDateString;
                        const statusSelect = document.getElementById('status');
                        if (attendanceData[dayDateString]) {
                            statusSelect.value = attendanceData[dayDateString].status;
                        } else {
                            statusSelect.value = 'present';
                        }
                        document.getElementById('note').value = attendanceData[dayDateString]?.note || '';
                        // Show modal using the Bootstrap data attributes
                        const event = new Event('click');
                        const modalElement = document.getElementById('attendanceModal');
                        const modalButton = document.querySelector(`[data-bs-target="#attendanceModal"]`);

                        // If Bootstrap is available, use it, otherwise manually show
                        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                            const modal = new bootstrap.Modal(modalElement);
                            modal.show();
                        } else {
                            // Manual fallback for showing modal
                            modalElement.style.display = 'block';
                            modalElement.classList.add('show');
                            modalElement.setAttribute('aria-modal', 'true');
                            modalElement.removeAttribute('aria-hidden');

                            // Add backdrop
                            const backdrop = document.createElement('div');
                            backdrop.className = 'modal-backdrop fade show';
                            document.body.appendChild(backdrop);
                            document.body.classList.add('modal-open');
                        }
                    } else {
                        alert('You cannot mark attendance for future dates.');
                    }
                });

                calendarDaysElement.appendChild(dayElement);
            }
        }

        // Update attendance statistics
        function updateAttendanceStats() {
            let presentCount = 0;
            let absentCount = 0;
            let lateCount = 0;

            const currentMonth = today.getMonth();
            const currentYear = today.getFullYear();

            Object.keys(attendanceData).forEach(date => {
                const attendanceDate = new Date(date);
                if (attendanceDate.getMonth() === currentMonth && attendanceDate.getFullYear() === currentYear) {
                    switch(attendanceData[date].status) {
                        case 'present':
                            presentCount++;
                            break;
                        case 'absent':
                            absentCount++;
                            break;
                        case 'late':
                            lateCount++;
                            break;
                    }
                }
            });

            const totalDays = presentCount + absentCount + lateCount;
            const presentPercent = totalDays > 0 ? (presentCount / totalDays) * 100 : 0;
            const absentPercent = totalDays > 0 ? (absentCount / totalDays) * 100 : 0;
            const latePercent = totalDays > 0 ? (lateCount / totalDays) * 100 : 0;

            document.getElementById('present-count').textContent = presentCount;
            document.getElementById('absent-count').textContent = absentCount;
            document.getElementById('late-count').textContent = lateCount;

            document.querySelector('.progress-bar.bg-success').style.width = presentPercent + '%';
            document.querySelector('.progress-bar.bg-danger').style.width = absentPercent + '%';
            document.querySelector('.progress-bar.bg-warning').style.width = latePercent + '%';
        }

        // Navigation buttons
        document.getElementById('prev-month').addEventListener('click', function() {
            currentMonth.setMonth(currentMonth.getMonth() - 1);
            renderCalendar(currentMonth);
        });

        document.getElementById('next-month').addEventListener('click', function() {
            currentMonth.setMonth(currentMonth.getMonth() + 1);
            renderCalendar(currentMonth);
        });

        // Mark today's attendance button
        document.getElementById('mark-today-attendance').addEventListener('click', function() {
            const todayDate = today.toISOString().split('T')[0];
            document.getElementById('date').value = todayDate;

            // Check if today's attendance already marked
            if (attendanceData[todayDate]) {
                // Pre-fill with existing data
                document.getElementById('status').value = attendanceData[todayDate].status;
                document.getElementById('note').value = attendanceData[todayDate].note || '';
            } else {
                document.getElementById('status').value = 'present';
                document.getElementById('note').value = '';
            }

            // Show modal using the Bootstrap data attributes
            const modalElement = document.getElementById('attendanceModal');

            // If Bootstrap is available, use it, otherwise manually show
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            } else {
                // Manual fallback for showing modal
                modalElement.style.display = 'block';
                modalElement.classList.add('show');
                modalElement.setAttribute('aria-modal', 'true');
                modalElement.removeAttribute('aria-hidden');

                // Add backdrop
                const backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop fade show';
                document.body.appendChild(backdrop);
                document.body.classList.add('modal-open');
            }
        });

        // Submit attendance
        document.getElementById('submit-attendance').addEventListener('click', function() {
            const formData = new FormData();
            formData.append('date', document.getElementById('date').value);
            formData.append('status', document.getElementById('status').value);
            formData.append('note', document.getElementById('note').value);
            formData.append('_token', '{{ csrf_token() }}');

            fetch('{{ route("attendance.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => {
                // Check if response is ok before parsing JSON
                if (!response.ok) {
                    // Handle HTTP error responses
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                // Check if response is JSON before parsing
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    return response.json();
                } else {
                    // If not JSON, return error
                    throw new Error('Server returned non-JSON response');
                }
            })
            .then(data => {
                if (data.success) {
                    // Update local data
                    const date = document.getElementById('date').value;
                    attendanceData[date] = {
                        status: document.getElementById('status').value,
                        note: document.getElementById('note').value
                    };

                    // Update calendar view
                    renderCalendar(currentMonth);
                    updateAttendanceStats();

                    // Close modal and show success message
                    // Hide modal using the Bootstrap data attributes
                    const modalElement = document.getElementById('attendanceModal');

                    // If Bootstrap is available, use it, otherwise manually hide
                    if (typeof bootstrap !== 'undefined' && bootstrap.Modal && bootstrap.Modal.getInstance) {
                        const modalInstance = bootstrap.Modal.getInstance(modalElement);
                        if (modalInstance) {
                            modalInstance.hide();
                        } else {
                            // Manual fallback for hiding modal
                            modalElement.style.display = 'none';
                            modalElement.classList.remove('show');
                            modalElement.setAttribute('aria-hidden', 'true');
                            modalElement.removeAttribute('aria-modal');

                            // Remove backdrop
                            const backdrop = document.querySelector('.modal-backdrop');
                            if (backdrop) backdrop.remove();
                            document.body.classList.remove('modal-open');
                        }
                    } else {
                        // Manual fallback for hiding modal
                        modalElement.style.display = 'none';
                        modalElement.classList.remove('show');
                        modalElement.setAttribute('aria-hidden', 'true');
                        modalElement.removeAttribute('aria-modal');

                        // Remove backdrop
                        const backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) backdrop.remove();
                        document.body.classList.remove('modal-open');
                    }
                    alert('Attendance marked successfully!');
                } else {
                    alert('Error: ' + (data.message || 'Failed to submit attendance'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Check if it's a validation error or network error
                alert('An error occurred while submitting attendance. Please check the console for details.');
            });
        });

        // Initial load
        loadAttendanceData();
    });
    </script>
@endsection