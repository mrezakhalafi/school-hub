<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Finance Record - {{ $financeRecord->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-section h2 {
            font-size: 18px;
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: auto auto;
            gap: 10px 20px;
        }
        .info-item {
            margin-bottom: 8px;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
        .value {
            color: #333;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-paid {
            background-color: #d4edda;
            color: #155724;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-overdue {
            background-color: #f8d7da;
            color: #721c24;
        }
        .status-cancelled {
            background-color: #e2e3e5;
            color: #383d41;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Finance Record</h1>
        <p>Transaction ID: {{ $financeRecord->id }}</p>
        <p>Date: {{ now()->format('M d, Y H:i:s') }}</p>
    </div>

    <div class="info-section">
        <h2>Transaction Details</h2>
        <div class="info-grid">
            <div class="info-item">
                <span class="label">Record ID:</span>
                <span class="value">{{ $financeRecord->id }}</span>
            </div>
            <div class="info-item">
                <span class="label">Amount:</span>
                <span class="value">Rp{{ number_format($financeRecord->amount, 0, ',', '.') }}</span>
            </div>
            <div class="info-item">
                <span class="label">Payment Type:</span>
                <span class="value">{{ ucfirst($financeRecord->payment_type) }}</span>
            </div>
            <div class="info-item">
                <span class="label">Payment Status:</span>
                <span class="value">
                    <span class="status-badge status-{{ $financeRecord->payment_status }}">
                        {{ ucfirst($financeRecord->payment_status) }}
                    </span>
                </span>
            </div>
            <div class="info-item">
                <span class="label">Due Date:</span>
                <span class="value">{{ $financeRecord->due_date ? $financeRecord->due_date->format('M d, Y') : '-' }}</span>
            </div>
            <div class="info-item">
                <span class="label">Paid Date:</span>
                <span class="value">{{ $financeRecord->paid_date ? $financeRecord->paid_date->format('M d, Y') : '-' }}</span>
            </div>
            <div class="info-item">
                <span class="label">Category:</span>
                <span class="value">{{ $financeRecord->category ?: '-' }}</span>
            </div>
            <div class="info-item">
                <span class="label">Payment Method:</span>
                <span class="value">{{ $financeRecord->payment_method ? ucfirst(str_replace('_', ' ', $financeRecord->payment_method)) : '-' }}</span>
            </div>
            <div class="info-item">
                <span class="label">Receipt Number:</span>
                <span class="value">{{ $financeRecord->receipt_number ?: '-' }}</span>
            </div>
        </div>
    </div>

    <div class="info-section">
        <h2>Student Information</h2>
        <div class="info-grid">
            <div class="info-item">
                <span class="label">Student Name:</span>
                <span class="value">{{ $financeRecord->student->first_name ?? '' }} {{ $financeRecord->student->last_name ?? '' }}</span>
            </div>
            <div class="info-item">
                <span class="label">Student ID:</span>
                <span class="value">{{ $financeRecord->student->id ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="label">Email:</span>
                <span class="value">{{ $financeRecord->student->email ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div class="info-section">
        <h2>Description & Notes</h2>
        <div class="info-item">
            <span class="label">Description:</span>
            <span class="value">{{ $financeRecord->description ?: '-' }}</span>
        </div>
        <div class="info-item">
            <span class="label">Notes:</span>
            <span class="value">{{ $financeRecord->notes ?: '-' }}</span>
        </div>
    </div>

    <div class="footer">
        <p>Generated on {{ now()->format('M d, Y H:i:s') }} | School Hub System</p>
    </div>
</body>
</html>