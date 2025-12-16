@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Student Dashboard</h1>
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
        <div class="col-md-6 mb-3">
            <a href="{{ route('events.index') }}">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title">Events</h4>
                                <p class="card-text">View school events</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 mb-3">
            <a href="{{ route('teachers.index') }}">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title">Teachers</h4>
                                <p class="card-text">View teachers</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Attendance Calendar Section -->
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Attendance Calendar</h5>
                </div>
                <div class="card-body">
                    <div class="calendar-container">
                        <div class="calendar-header d-flex justify-content-between align-items-center mb-3">
                            <button class="btn btn-outline-secondary" id="prev-month">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <h4 id="current-month-year">{{ now()->isoFormat('MMMM YYYY') }}</h4>
                            <button class="btn btn-outline-secondary" id="next-month">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                        
                        <div class="weekdays row g-1">
                            <div class="col text-center py-1">Sun</div>
                            <div class="col text-center py-1">Mon</div>
                            <div class="col text-center py-1">Tue</div>
                            <div class="col text-center py-1">Wed</div>
                            <div class="col text-center py-1">Thu</div>
                            <div class="col text-center py-1">Fri</div>
                            <div class="col text-center py-1">Sat</div>
                        </div>
                        
                        <div id="calendar-days" class="row g-1">
                            <!-- Calendar days will be populated dynamically -->
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <button type="button" class="btn btn-success btn-lg" id="mark-today-attendance">
                            <i class="fas fa-check-circle"></i> Mark Today's Attendance
                        </button>
                        <small class="text-muted ms-2">Click to mark present for today</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Attendance Summary</h5>
                </div>
                <div class="card-body">
                    <div class="attendance-stats">
                        <h6>This Month</h6>
                        <ul class="list-unstyled">
                            <li><strong>Present:</strong> <span id="present-count">0</span> days</li>
                            <li><strong>Absent:</strong> <span id="absent-count">0</span> days</li>
                            <li><strong>Late:</strong> <span id="late-count">0</span> days</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Legend</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-present me-2">●</span> Present
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge badge-absent me-2">●</span> Absent
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge badge-late me-2">●</span> Late
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge badge-today me-2">●</span> Today
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
            <div class="modal-header">
                <h5 class="modal-title" id="attendanceModalLabel">Mark Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="attendance-form">
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                            <option value="late">Late</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note (optional)</label>
                        <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="submit-attendance">Submit</button>
            </div>
        </div>
    </div>
</div>

<style>
    .calendar-container {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 1rem;
    }
    
    .weekdays div {
        font-weight: bold;
        background-color: #f8f9fa;
    }
    
    .calendar-day {
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #dee2e6;
        cursor: pointer;
        position: relative;
    }
    
    .calendar-day:hover {
        background-color: #e9ecef;
    }
    
    .calendar-day.other-month {
        background-color: #f8f9fa;
        color: #6c757d;
    }
    
    .calendar-day.past-day {
        opacity: 0.7;
    }
    
    .calendar-day.today {
        background-color: #d1ecf1;
        border: 2px solid #0dcaf0;
        font-weight: bold;
    }
    
    .calendar-day.attendance-present::after {
        content: '';
        position: absolute;
        bottom: 2px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #198754;
    }
    
    .calendar-day.attendance-absent::after {
        content: '';
        position: absolute;
        bottom: 2px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #dc3545;
    }
    
    .calendar-day.attendance-late::after {
        content: '';
        position: absolute;
        bottom: 2px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #ffc107;
    }
    
    .badge {
        font-size: 1rem;
        font-weight: bold;
    }
    
    .badge-present {
        color: #198754;
    }
    
    .badge-absent {
        color: #dc3545;
    }
    
    .badge-late {
        color: #ffc107;
    }
    
    .badge-today {
        color: #0dcaf0;
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
                    const modal = new bootstrap.Modal(document.getElementById('attendanceModal'));
                    modal.show();
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

        document.getElementById('present-count').textContent = presentCount;
        document.getElementById('absent-count').textContent = absentCount;
        document.getElementById('late-count').textContent = lateCount;
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

        const modal = new bootstrap.Modal(document.getElementById('attendanceModal'));
        modal.show();
    });

    // Submit attendance
    document.getElementById('submit-attendance').addEventListener('click', function() {
        const formData = new FormData();
        formData.append('user_id', userId);
        formData.append('date', document.getElementById('date').value);
        formData.append('status', document.getElementById('status').value);
        formData.append('note', document.getElementById('note').value);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("attendance.store") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
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
                bootstrap.Modal.getInstance(document.getElementById('attendanceModal')).hide();
                alert('Attendance marked successfully!');
            } else {
                alert('Error: ' + (data.message || 'Failed to submit attendance'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while submitting attendance.');
        });
    });

    // Initial load
    loadAttendanceData();
});
</script>
@endsection