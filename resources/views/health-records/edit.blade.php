@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6 fw-bold text-primary">Edit Health Record</h1>
        <a href="{{ route('health-records.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Records
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('health-records.update', $healthRecord) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="student_id" class="form-label fw-bold">Student <span class="text-danger">*</span></label>
                                    <select name="student_id" id="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                                        <option value="">Select Student</option>
                                        @foreach($students as $student)
                                            <option value="{{ $student->id }}" {{ old('student_id', $healthRecord->student_id) == $student->id ? 'selected' : '' }}>
                                                {{ $student->name }} ({{ $student->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('student_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date_checked" class="form-label fw-bold">Date Checked</label>
                                    <input type="date" name="date_checked" id="date_checked" class="form-control @error('date_checked') is-invalid @enderror" value="{{ old('date_checked', $healthRecord->date_checked) }}">
                                    @error('date_checked')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="height" class="form-label fw-bold">Height (cm)</label>
                                    <input type="number" name="height" id="height" class="form-control @error('height') is-invalid @enderror" value="{{ old('height', $healthRecord->height) }}" placeholder="e.g., 150">
                                    @error('height')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="weight" class="form-label fw-bold">Weight (kg)</label>
                                    <input type="number" step="0.01" name="weight" id="weight" class="form-control @error('weight') is-invalid @enderror" value="{{ old('weight', $healthRecord->weight) }}" placeholder="e.g., 50.5">
                                    @error('weight')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="blood_pressure" class="form-label fw-bold">Blood Pressure</label>
                                    <input type="text" name="blood_pressure" id="blood_pressure" class="form-control @error('blood_pressure') is-invalid @enderror" value="{{ old('blood_pressure', $healthRecord->blood_pressure) }}" placeholder="e.g., 120/80">
                                    @error('blood_pressure')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="vision_test_result" class="form-label fw-bold">Vision Test Result</label>
                                    <input type="text" name="vision_test_result" id="vision_test_result" class="form-control @error('vision_test_result') is-invalid @enderror" value="{{ old('vision_test_result', $healthRecord->vision_test_result) }}" placeholder="e.g., 20/20">
                                    @error('vision_test_result')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hearing_test_result" class="form-label fw-bold">Hearing Test Result</label>
                                    <input type="text" name="hearing_test_result" id="hearing_test_result" class="form-control @error('hearing_test_result') is-invalid @enderror" value="{{ old('hearing_test_result', $healthRecord->hearing_test_result) }}" placeholder="e.g., Normal">
                                    @error('hearing_test_result')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dental_health" class="form-label fw-bold">Dental Health</label>
                                    <input type="text" name="dental_health" id="dental_health" class="form-control @error('dental_health') is-invalid @enderror" value="{{ old('dental_health', $healthRecord->dental_health) }}" placeholder="e.g., Good">
                                    @error('dental_health')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="allergies" class="form-label fw-bold">Allergies</label>
                            <textarea name="allergies[]" id="allergies" class="form-control @error('allergies') is-invalid @enderror" rows="2" placeholder="Enter allergies separated by commas">{{ old('allergies') ? implode(', ', old('allergies')) : ($healthRecord->allergies ? implode(', ', $healthRecord->allergies) : '') }}</textarea>
                            <small class="text-muted">Separate multiple allergies with commas</small>
                            @error('allergies')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="medical_conditions" class="form-label fw-bold">Medical Conditions</label>
                            <textarea name="medical_conditions[]" id="medical_conditions" class="form-control @error('medical_conditions') is-invalid @enderror" rows="2" placeholder="Enter medical conditions separated by commas">{{ old('medical_conditions') ? implode(', ', old('medical_conditions')) : ($healthRecord->medical_conditions ? implode(', ', $healthRecord->medical_conditions) : '') }}</textarea>
                            <small class="text-muted">Separate multiple medical conditions with commas</small>
                            @error('medical_conditions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="medications" class="form-label fw-bold">Medications</label>
                            <textarea name="medications" id="medications" class="form-control @error('medications') is-invalid @enderror" rows="3">{{ old('medications', $healthRecord->medications) }}</textarea>
                            @error('medications')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="emergency_contact" class="form-label fw-bold">Emergency Contact</label>
                            <input type="text" name="emergency_contact" id="emergency_contact" class="form-control @error('emergency_contact') is-invalid @enderror" value="{{ old('emergency_contact', $healthRecord->emergency_contact) }}" placeholder="Name and phone number">
                            @error('emergency_contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="immunization_records" class="form-label fw-bold">Immunization Records</label>
                            <textarea name="immunization_records[]" id="immunization_records" class="form-control @error('immunization_records') is-invalid @enderror" rows="2" placeholder="Enter immunizations separated by commas">{{ old('immunization_records') ? implode(', ', old('immunization_records')) : ($healthRecord->immunization_records ? implode(', ', $healthRecord->immunization_records) : '') }}</textarea>
                            <small class="text-muted">Separate multiple immunizations with commas</small>
                            @error('immunization_records')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="checked_by" class="form-label fw-bold">Checked By</label>
                            <input type="text" name="checked_by" id="checked_by" class="form-control @error('checked_by') is-invalid @enderror" value="{{ old('checked_by', $healthRecord->checked_by) }}" placeholder="Healthcare provider name">
                            @error('checked_by')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('health-records.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Health Record</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection