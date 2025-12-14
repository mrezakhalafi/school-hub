@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Student Dashboard</h1>
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

    <!-- Attendance Form for Students -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Submit Attendance</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('attendance.store') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="date" value="{{ date('Y-m-d') }}">

                        <div class="mb-3">
                            <label for="status" class="form-label">Attendance Status</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="">Select Status</option>
                                <option value="present">Present</option>
                                <option value="absent">Absent</option>
                                <option value="late">Late</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Note (Optional)</label>
                            <textarea name="note" id="note" class="form-control" rows="3" placeholder="Any additional note..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit Attendance</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection