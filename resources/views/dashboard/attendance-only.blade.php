@extends('layouts.app')

@section('title', 'Attendance')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Attendance System</h4>
                </div>
                <div class="card-body">
                    <p>Welcome {{ $user->name }}!</p>
                    
                    <form method="POST" action="{{ route('attendance.store') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
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