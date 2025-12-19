<?php

namespace App\Http\Controllers;

use App\Models\FinanceRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FinanceRecordController extends Controller
{
    public function index()
    {
        $financeRecords = FinanceRecord::with('student')->latest()->paginate(10);

        // Calculate totals
        $totalPending = FinanceRecord::where('payment_status', 'pending')->sum('amount');
        $totalPaid = FinanceRecord::where('payment_status', 'paid')->sum('amount');
        $totalOverdue = FinanceRecord::where('payment_status', 'overdue')->sum('amount');

        return view('finance-records.index', compact('financeRecords', 'totalPending', 'totalPaid', 'totalOverdue'));
    }

    public function create()
    {
        $students = User::where('role', 'student')->get();
        return view('finance-records.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'payment_type' => 'required|string|max:100',
            'payment_status' => 'required|in:pending,paid,overdue,cancelled',
            'due_date' => 'required|date',
            'paid_date' => 'nullable|date|after_or_equal:due_date',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'receipt_number' => 'nullable|string|max:100',
            'payment_method' => 'nullable|in:cash,bank_transfer,credit_card,gopay,dana,ovo',
            'notes' => 'nullable|string',
        ]);

        FinanceRecord::create($validatedData);

        return redirect()->route('finance-records.index')
            ->with('success', 'Finance record created successfully.');
    }

    public function show(FinanceRecord $financeRecord)
    {
        $financeRecord->load('student');
        return view('finance-records.show', compact('financeRecord'));
    }

    public function edit(FinanceRecord $financeRecord)
    {
        $students = User::where('role', 'student')->get();
        return view('finance-records.edit', compact('financeRecord', 'students'));
    }

    public function update(Request $request, FinanceRecord $financeRecord)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'payment_type' => 'required|string|max:100',
            'payment_status' => 'required|in:pending,paid,overdue,cancelled',
            'due_date' => 'required|date',
            'paid_date' => 'nullable|date|after_or_equal:due_date',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'receipt_number' => 'nullable|string|max:100',
            'payment_method' => 'nullable|in:cash,bank_transfer,credit_card,gopay,dana,ovo',
            'notes' => 'nullable|string',
        ]);

        $financeRecord->update($validatedData);

        return redirect()->route('finance-records.index')
            ->with('success', 'Finance record updated successfully.');
    }

    public function destroy(FinanceRecord $financeRecord)
    {
        $financeRecord->delete();

        return redirect()->route('finance-records.index')
            ->with('success', 'Finance record deleted successfully.');
    }

    public function markAsPaid(FinanceRecord $financeRecord)
    {
        $financeRecord->update([
            'payment_status' => 'paid',
            'paid_date' => Carbon::now()->toDateString(),
        ]);

        return redirect()->back()->with('success', 'Payment marked as paid successfully.');
    }
}
