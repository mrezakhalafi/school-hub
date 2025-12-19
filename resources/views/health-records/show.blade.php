@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6 fw-bold text-primary">Health Record Details</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('health-records.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back to Records
            </a>
            <a href="{{ route('health-records.edit', $healthRecord) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i> Edit
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-4 px-4">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-user text-primary me-2"></i>
                        Student Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Student Name:</strong> {{ $healthRecord->student->name ?? 'N/A' }}</p>
                            <p><strong>Student Email:</strong> {{ $healthRecord->student->email ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Date Checked:</strong> {{ $healthRecord->date_checked ? $healthRecord->date_checked->format('M d, Y') : 'N/A' }}</p>
                            <p><strong>Checked By:</strong> {{ $healthRecord->checked_by ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-white border-0 py-4 px-4">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-heartbeat text-success me-2"></i>
                        Health Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Height:</strong> {{ $healthRecord->height ? $healthRecord->height . ' cm' : 'N/A' }}</p>
                            <p><strong>Blood Pressure:</strong> {{ $healthRecord->blood_pressure ?? 'N/A' }}</p>
                            <p><strong>Vision Test Result:</strong> {{ $healthRecord->vision_test_result ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Weight:</strong> {{ $healthRecord->weight ? $healthRecord->weight . ' kg' : 'N/A' }}</p>
                            <p><strong>Hearing Test Result:</strong> {{ $healthRecord->hearing_test_result ?? 'N/A' }}</p>
                            <p><strong>Dental Health:</strong> {{ $healthRecord->dental_health ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($healthRecord->allergies || $healthRecord->medical_conditions || $healthRecord->medications)
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-white border-0 py-4 px-4">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                        Medical Information
                    </h5>
                </div>
                <div class="card-body">
                    @if($healthRecord->allergies && count($healthRecord->allergies) > 0)
                    <div class="mb-3">
                        <p><strong>Allergies:</strong></p>
                        <ul class="list-group">
                            @foreach($healthRecord->allergies as $allergy)
                                <li class="list-group-item">{{ $allergy }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if($healthRecord->medical_conditions && count($healthRecord->medical_conditions) > 0)
                    <div class="mb-3">
                        <p><strong>Medical Conditions:</strong></p>
                        <ul class="list-group">
                            @foreach($healthRecord->medical_conditions as $condition)
                                <li class="list-group-item">{{ $condition }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if($healthRecord->medications)
                    <div class="mb-3">
                        <p><strong>Medications:</strong></p>
                        <p>{{ $healthRecord->medications }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-white border-0 py-4 px-4">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-file-medical text-info me-2"></i>
                        Additional Information
                    </h5>
                </div>
                <div class="card-body">
                    @if($healthRecord->emergency_contact)
                    <div class="mb-3">
                        <p><strong>Emergency Contact:</strong></p>
                        <p>{{ $healthRecord->emergency_contact }}</p>
                    </div>
                    @endif

                    @if($healthRecord->immunization_records && count($healthRecord->immunization_records) > 0)
                    <div class="mb-3">
                        <p><strong>Immunization Records:</strong></p>
                        <ul class="list-group">
                            @foreach($healthRecord->immunization_records as $immunization)
                                <li class="list-group-item">{{ $immunization }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-4 px-4">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-clipboard-list text-primary me-2"></i>
                        Health Status
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        @if($healthRecord->medical_conditions && count($healthRecord->medical_conditions) > 0)
                            <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                            <h3 class="text-warning mt-2">Needs Attention</h3>
                        @else
                            <i class="fas fa-heart text-success" style="font-size: 3rem;"></i>
                            <h3 class="text-success mt-2">Healthy</h3>
                        @endif
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('health-records.edit', $healthRecord) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i> Edit Record
                        </a>
                        <form method="POST" action="{{ route('health-records.destroy', $healthRecord) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this health record?')">
                                <i class="fas fa-trash me-2"></i> Delete Record
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection