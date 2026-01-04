@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-md border-0">
                <div class="card-header bg-primary text-white py-4">
                    <h4 class="card-title mb-0 fw-bold">
                        <i class="fas fa-school me-2"></i>School Information
                    </h4>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('school-information.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="school_name" class="form-label fw-semibold">School Name</label>
                                <input type="text" class="form-control @error('school_name') is-invalid @enderror" 
                                       id="school_name" name="school_name" 
                                       value="{{ old('school_name', $schoolInfo->school_name) }}" required>
                                @error('school_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="head_of_school" class="form-label fw-semibold">Head of School</label>
                                <input type="text" class="form-control @error('head_of_school') is-invalid @enderror" 
                                       id="head_of_school" name="head_of_school" 
                                       value="{{ old('head_of_school', $schoolInfo->head_of_school) }}" required>
                                @error('head_of_school')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="location" class="form-label fw-semibold">Location</label>
                            <textarea class="form-control @error('location') is-invalid @enderror" 
                                      id="location" name="location" rows="3" required>{{ old('location', $schoolInfo->location) }}</textarea>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="history" class="form-label fw-semibold">School History</label>
                            <textarea class="form-control @error('history') is-invalid @enderror" 
                                      id="history" name="history" rows="5" required>{{ old('history', $schoolInfo->history) }}</textarea>
                            @error('history')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="building_features" class="form-label fw-semibold">Building Features</label>
                            <textarea class="form-control @error('building_features') is-invalid @enderror" 
                                      id="building_features" name="building_features" rows="4" required>{{ old('building_features', $schoolInfo->building_features) }}</textarea>
                            @error('building_features')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="extracurricular_activities" class="form-label fw-semibold">Extracurricular Activities</label>
                            <textarea class="form-control @error('extracurricular_activities') is-invalid @enderror"
                                      id="extracurricular_activities" name="extracurricular_activities" rows="4" required>{{ old('extracurricular_activities', $schoolInfo->extracurricular_activities) }}</textarea>
                            @error('extracurricular_activities')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="accreditation" class="form-label fw-semibold">Accreditation</label>
                                <input type="text" class="form-control @error('accreditation') is-invalid @enderror"
                                       id="accreditation" name="accreditation"
                                       value="{{ old('accreditation', $schoolInfo->accreditation) }}" maxlength="10">
                                @error('accreditation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="founding_year" class="form-label fw-semibold">Founding Year</label>
                                <input type="number" class="form-control @error('founding_year') is-invalid @enderror"
                                       id="founding_year" name="founding_year"
                                       value="{{ old('founding_year', $schoolInfo->founding_year) }}" min="1800" max="2100">
                                @error('founding_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="student_capacity" class="form-label fw-semibold">Student Capacity</label>
                                <input type="number" class="form-control @error('student_capacity') is-invalid @enderror"
                                       id="student_capacity" name="student_capacity"
                                       value="{{ old('student_capacity', $schoolInfo->student_capacity) }}" min="0">
                                @error('student_capacity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                <i class="fas fa-save me-2"></i>Update Information
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection