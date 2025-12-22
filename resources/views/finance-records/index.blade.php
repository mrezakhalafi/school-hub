@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6 fw-bold text-primary">Finance Sekolah</h1>
        <a href="{{ route('finance-records.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add New Record
        </a>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-lg border-0 bg-gradient-to-br from-blue-50 to-indigo-50">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Records</p>
                            <h3 class="fw-bold mb-0">{{ $financeRecords->total() }}</h3>
                        </div>
                        <div class="p-3 rounded-circle bg-blue-100 dashboard-card-icon">
                            <i class="fas fa-file-invoice text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-lg border-0 bg-gradient-to-br from-green-50 to-emerald-50">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Paid</p>
                            <h3 class="fw-bold mb-0">Rp{{ number_format($totalPaid, 0, ',', '.') }}</h3>
                        </div>
                        <div class="p-3 rounded-circle bg-green-100 dashboard-card-icon">
                            <i class="fas fa-check-circle text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-lg border-0 bg-gradient-to-br from-orange-50 to-amber-50">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Pending Payments</p>
                            <h3 class="fw-bold mb-0">Rp{{ number_format($totalPending, 0, ',', '.') }}</h3>
                        </div>
                        <div class="p-3 rounded-circle bg-orange-100 dashboard-card-icon">
                            <i class="fas fa-clock text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-lg border-0 bg-gradient-to-br from-red-50 to-pink-50">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Overdue Amount</p>
                            <h3 class="fw-bold mb-0">Rp{{ number_format($totalOverdue, 0, ',', '.') }}</h3>
                        </div>
                        <div class="p-3 rounded-circle bg-red-100 dashboard-card-icon">
                            <i class="fas fa-exclamation-circle text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card shadow-lg border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('finance-records.index') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="search" placeholder="Search by student name..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="payment_status" class="form-select">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="overdue" {{ request('payment_status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                            <option value="cancelled" {{ request('payment_status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="payment_type" class="form-select">
                            <option value="">All Types</option>
                            <option value="tuition" {{ request('payment_type') == 'tuition' ? 'selected' : '' }}>Tuition</option>
                            <option value="fee" {{ request('payment_type') == 'fee' ? 'selected' : '' }}>Fee</option>
                            <option value="fine" {{ request('payment_type') == 'fine' ? 'selected' : '' }}>Fine</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i> Search</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('finance-records.index') }}" class="btn btn-outline-secondary w-100">Clear</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Finance Records Table -->
    <div class="card shadow-lg border-0">
        <div class="card-header bg-white border-0 py-4 px-4">
            <h5 class="card-title mb-0 fw-bold">
                <i class="fas fa-money-bill-wave text-success me-2"></i>
                Finance Records
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Student</th>
                            <th>Amount</th>
                            <th>Payment Type</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th>Paid Date</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($financeRecords as $index => $record)
                        <tr>
                            <td>{{ ($financeRecords->currentPage() - 1) * $financeRecords->perPage() + $index + 1 }}</td>
                            <td>
                                <a href="{{ route('finance-records.show', $record) }}" class="text-decoration-none fw-medium">
                                    {{ $record->student->first_name ?? '' }} {{ $record->student->last_name ?? '' }}
                                </a>
                            </td>
                            <td>Rp{{ number_format($record->amount, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ $record->payment_type == 'tuition' ? 'primary' : ($record->payment_type == 'fee' ? 'info' : 'warning') }} rounded-pill px-3 py-2">
                                    {{ ucfirst($record->payment_type) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge
                                    @if($record->payment_status == 'paid') bg-success
                                    @elseif($record->payment_status == 'pending') bg-warning text-dark
                                    @elseif($record->payment_status == 'overdue') bg-danger
                                    @else bg-secondary
                                    @endif rounded-pill px-3 py-2">
                                    {{ ucfirst($record->payment_status) }}
                                </span>
                            </td>
                            <td>{{ $record->due_date ? $record->due_date->format('M d, Y') : '-' }}</td>
                            <td>{{ $record->paid_date ? $record->paid_date->format('M d, Y') : '-' }}</td>
                            <td>{{ $record->category ?: '-' }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('finance-records.show', $record) }}"><i class="fas fa-eye me-2"></i> View</a></li>
                                        <li><a class="dropdown-item" href="{{ route('finance-records.edit', $record) }}"><i class="fas fa-edit me-2"></i> Edit</a></li>
                                        @if($record->payment_status == 'pending')
                                        <li>
                                            <a class="dropdown-item text-success" href="{{ route('finance-records.markAsPaid', $record) }}">
                                                <i class="fas fa-check me-2"></i> Mark as Paid
                                            </a>
                                        </li>
                                        @endif
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('finance-records.destroy', $record) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this finance record?')">
                                                    <i class="fas fa-trash me-2"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <i class="fas fa-money-bill-wave text-muted mb-3 dashboard-card-icon"></i>
                                <p class="text-muted">No finance records found.</p>
                                <a href="{{ route('finance-records.create') }}" class="btn btn-primary">Add New Record</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $financeRecords->links() }}
            </div>
        </div>
    </div>
</div>
@endsection