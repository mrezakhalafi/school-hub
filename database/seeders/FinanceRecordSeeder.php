<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FinanceRecord;
use App\Models\Student;
use Illuminate\Support\Carbon;

class FinanceRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::all();

        if ($students->count() > 0) {
            // Create a fixed number of finance records (not one per student)
            $totalRecords = 50; // Fixed number as requested

            for ($i = 0; $i < $totalRecords; $i++) {
                $randomStudent = $students->random(); // Pick a random student
                $paymentType = ['tuition', 'fee', 'fine'][array_rand(['tuition', 'fee', 'fine'])];
                $status = ['pending', 'paid', 'overdue'][array_rand(['pending', 'paid', 'overdue'])];
                $dueDate = Carbon::now()->subDays(rand(-30, 180));
                $paidDate = null;

                if ($status === 'paid') {
                    $paidDate = $dueDate->copy()->addDays(rand(0, 10));
                }

                FinanceRecord::create([
                    'student_id' => $randomStudent->id,
                    'amount' => rand(200000, 5000000),
                    'payment_type' => $paymentType,
                    'payment_status' => $status,
                    'due_date' => $dueDate,
                    'paid_date' => $paidDate,
                    'description' => $paymentType . ' payment for ' . $randomStudent->first_name . ' ' . $randomStudent->last_name,
                    'category' => ucfirst($paymentType) . ' Fee',
                    'receipt_number' => 'RCP-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                    'payment_method' => ['cash', 'bank_transfer', 'credit_card', 'gopay', 'dana', 'ovo'][array_rand(['cash', 'bank_transfer', 'credit_card', 'gopay', 'dana', 'ovo'])],
                    'notes' => 'Payment for ' . $paymentType . ' fee'
                ]);
            }
        }
    }
}
