@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Add New Schedule for {{ $class->name }}</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Schedule Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('schedules.store', $class->id) }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="day" class="form-label">Day</label>
                                    <select name="day" id="day" class="form-select @error('day') is-invalid @enderror" required>
                                        <option value="">Select Day</option>
                                        @foreach($days as $dayOption)
                                            <option value="{{ $dayOption }}" {{ old('day') == $dayOption ? 'selected' : '' }}>
                                                {{ $dayOption }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('day')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hour" class="form-label">Hour</label>
                                    <select name="hour" id="hour" class="form-select @error('hour') is-invalid @enderror" required>
                                        <option value="">Select Hour (7 AM to 2 PM)</option>
                                        @foreach($hours as $hourOption)
                                            <option value="{{ $hourOption }}" {{ old('hour') == $hourOption ? 'selected' : '' }}>
                                                {{ $hourOption }}:00
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('hour')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror" 
                                   value="{{ old('subject') }}" required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="teacher_id" class="form-label">Teacher (Optional)</label>
                            <select name="teacher_id" id="teacher_id" class="form-select @error('teacher_id') is-invalid @enderror">
                                <option value="">Select Teacher</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->first_name }} {{ $teacher->last_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('teacher_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('classes.show', $class->id) }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Schedule</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection