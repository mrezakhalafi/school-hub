@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6 fw-bold text-primary">Finance Record Details</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('finance-records.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back to Records
            </a>
            <a href="{{ route('finance-records.edit', $financeRecord) }}" class="btn btn-primary">
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
                            <p><strong>Student Name:</strong> {{ $financeRecord->student->name ?? 'N/A' }}</p>
                            <p><strong>Student Email:</strong> {{ $financeRecord->student->email ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Payment Type:</strong> 
                                <span class="badge bg-{{ $financeRecord->payment_type == 'tuition' ? 'primary' : ($financeRecord->payment_type == 'fee' ? 'info' : 'warning') }} rounded-pill px-3 py-2">
                                    {{ ucfirst($financeRecord->payment_type) }}
                                </span>
                            </p>
                            <p><strong>Category:</strong> {{ $financeRecord->category ?: 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-white border-0 py-4 px-4">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-money-bill-wave text-success me-2"></i>
                        Payment Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Amount:</strong> <span class="fs-4 fw-bold text-primary">Rp{{ number_format($financeRecord->amount, 0, ',', '.') }}</span></p>
                            <p><strong>Payment Status:</strong> 
                                <span class="badge 
                                    @if($financeRecord->payment_status == 'paid') bg-success
                                    @elseif($financeRecord->payment_status == 'pending') bg-warning text-dark
                                    @elseif($financeRecord->payment_status == 'overdue') bg-danger
                                    @else bg-secondary
                                    @endif rounded-pill px-3 py-2">
                                    {{ ucfirst($financeRecord->payment_status) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Due Date:</strong> {{ $financeRecord->due_date ? $financeRecord->due_date->format('M d, Y') : 'N/A' }}</p>
                            <p><strong>Paid Date:</strong> {{ $financeRecord->paid_date ? $financeRecord->paid_date->format('M d, Y') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-white border-0 py-4 px-4">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-receipt text-info me-2"></i>
                        Transaction Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Receipt Number:</strong> {{ $financeRecord->receipt_number ?: 'N/A' }}</p>
                            <p><strong>Payment Method:</strong> {{ $financeRecord->payment_method ? ucfirst($financeRecord->payment_method) : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Description:</strong> {{ $financeRecord->description ?: 'N/A' }}</p>
                        </div>
                    </div>
                    @if($financeRecord->notes)
                    <div class="mt-3">
                        <p><strong>Notes:</strong></p>
                        <p>{{ $financeRecord->notes }}</p>
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
                        Payment Actions
                    </h5>
                </div>
                <div class="card-body">
                    @if($financeRecord->payment_status == 'pending')
                    <div class="mb-3">
                        <a href="{{ route('finance-records.markAsPaid', $financeRecord) }}" class="btn btn-success w-100" onclick="return confirm('Are you sure you want to mark this payment as paid?')">
                            <i class="fas fa-check me-2"></i> Mark as Paid
                        </a>
                    </div>
                    @endif
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('finance-records.edit', $financeRecord) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i> Edit Record
                        </a>
                        <form method="POST" action="{{ route('finance-records.destroy', $financeRecord) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this finance record?')">
                                <i class="fas fa-trash me-2"></i> Delete Record
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-white border-0 py-4 px-4">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-pie text-info me-2"></i>
                        Payment Summary
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-money-bill-wave" style="font-size: 3rem;"></i>
                    </div>
                    <h2 class="text-primary fw-bold">Rp{{ number_format($financeRecord->amount, 0, ',', '.') }}</h2>
                    <p class="text-muted">Payment Amount</p>
                    
                    <div class="mt-4">
                        <div class="progress mb-2" style="height: 10px;">
                            @if($financeRecord->payment_status == 'paid')
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                            @elseif($financeRecord->payment_status == 'pending')
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 50%"></div>
                            @elseif($financeRecord->payment_status == 'overdue')
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 30%"></div>
                            @else
                                <div class="progress-bar bg-secondary" role="progressbar" style="width: 0%"></div>
                            @endif
                        </div>
                        <small class="text-muted">
                            @if($financeRecord->payment_status == 'paid')
                                Payment completed
                            @elseif($financeRecord->payment_status == 'pending')
                                Payment pending
                            @elseif($financeRecord->payment_status == 'overdue')
                                Payment overdue
                            @else
                                Payment cancelled
                            @endif
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection