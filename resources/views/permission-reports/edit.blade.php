@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Edit Permission Report</h1>
                <a href="{{ route('permission-reports.index') }}" class="btn btn-secondary">Back to List</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('permission-reports.update', $permissionReport) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student</label>
                            <select name="student_id" id="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                                <option value="">Select a student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" 
                                        data-name="{{ $student->first_name . ' ' . $student->last_name }}" 
                                        data-class="{{ $student->class ? $student->class->name : 'N/A' }}"
                                        {{ $student->id == $permissionReport->student_id ? 'selected' : '' }}>
                                        {{ $student->first_name . ' ' . $student->last_name }} ({{ $student->class ? $student->class->name : 'No class' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="hidden" name="student_name" id="student_name" value="{{ old('student_name', $permissionReport->student_name) }}">

                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student</label>
                            <select name="student_id" id="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                                <option value="">Select a student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}"
                                        data-name="{{ $student->first_name . ' ' . $student->last_name }}"
                                        data-class="{{ $student->class ? $student->class->name : 'N/A' }}"
                                        {{ $student->id == $permissionReport->student_id ? 'selected' : '' }}>
                                        {{ $student->first_name . ' ' . $student->last_name }} ({{ $student->class ? $student->class->name : 'No class' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="permission_date" class="form-label">Permission Date</label>
                                    <input type="date" name="permission_date" id="permission_date" class="form-control @error('permission_date') is-invalid @enderror" value="{{ old('permission_date', $permissionReport->permission_date->format('Y-m-d')) }}" required>
                                    @error('permission_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="permission_time" class="form-label">Permission Time</label>
                                    <input type="time" name="permission_time" id="permission_time" class="form-control @error('permission_time') is-invalid @enderror" value="{{ old('permission_time', $permissionReport->permission_time) }}" required>
                                    @error('permission_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="permission_type" class="form-label">Permission Type</label>
                            <select name="permission_type" id="permission_type" class="form-select @error('permission_type') is-invalid @enderror" required>
                                <option value="">Select permission type</option>
                                <option value="sick" {{ old('permission_type', $permissionReport->permission_type) == 'sick' ? 'selected' : '' }}>Sick</option>
                                <option value="event" {{ old('permission_type', $permissionReport->permission_type) == 'event' ? 'selected' : '' }}>Event</option>
                                <option value="family" {{ old('permission_type', $permissionReport->permission_type) == 'family' ? 'selected' : '' }}>Family</option>
                                <option value="other" {{ old('permission_type', $permissionReport->permission_type) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('permission_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="reason" class="form-label">Reason</label>
                            <textarea name="reason" id="reason" class="form-control @error('reason') is-invalid @enderror" rows="4" required>{{ old('reason', $permissionReport->reason) }}</textarea>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('permission-reports.index') }}" class="btn btn-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Permission Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const studentSelect = document.getElementById('student_id');
    const studentNameInput = document.getElementById('student_name');
    const classNameInput = document.getElementById('class_name');

    studentSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            studentNameInput.value = selectedOption.getAttribute('data-name');
            if (classNameInput) {
                classNameInput.value = selectedOption.getAttribute('data-class');
            }
        } else {
            studentNameInput.value = '';
            if (classNameInput) {
                classNameInput.value = '';
            }
        }
    });
});
</script>
@endsection