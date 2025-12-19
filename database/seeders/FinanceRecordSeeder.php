<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FinanceRecord;
use App\Models\User;
use Illuminate\Support\Carbon;

class FinanceRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all students
        $students = User::where('role', 'student')->get();

        if ($students->count() > 0) {
            foreach ($students as $index => $student) {
                // Create some finance records for each student
                for ($i = 0; $i < rand(2, 4); $i++) {
                    $paymentType = ['tuition', 'fee', 'fine'][array_rand(['tuition', 'fee', 'fine'])];
                    $status = ['pending', 'paid', 'overdue'][array_rand(['pending', 'paid', 'overdue'])];
                    $dueDate = Carbon::now()->subDays(rand(-30, 90));
                    $paidDate = null;

                    if ($status === 'paid') {
                        $paidDate = $dueDate->copy()->addDays(rand(0, 10));
                    }

                    FinanceRecord::create([
                        'student_id' => $student->id,
                        'amount' => rand(200000, 5000000),
                        'payment_type' => $paymentType,
                        'payment_status' => $status,
                        'due_date' => $dueDate,
                        'paid_date' => $paidDate,
                        'description' => $paymentType . ' payment for ' . $student->name,
                        'category' => ucfirst($paymentType) . ' Fee',
                        'receipt_number' => 'RCP-' . str_pad($student->id * 10 + $i, 4, '0', STR_PAD_LEFT),
                        'payment_method' => ['cash', 'bank_transfer', 'credit_card', 'gopay', 'dana', 'ovo'][array_rand(['cash', 'bank_transfer', 'credit_card', 'gopay', 'dana', 'ovo'])],
                        'notes' => 'Payment for ' . $paymentType . ' fee'
                    ]);
                }
            }
        } else {
            // If no students exist, create finance records for any user with student role
            $users = User::where('role', 'student')->take(5)->get();
            foreach ($users as $index => $user) {
                // Create some finance records for each student
                for ($i = 0; $i < rand(2, 4); $i++) {
                    $paymentType = ['tuition', 'fee', 'fine'][array_rand(['tuition', 'fee', 'fine'])];
                    $status = ['pending', 'paid', 'overdue'][array_rand(['pending', 'paid', 'overdue'])];
                    $dueDate = Carbon::now()->subDays(rand(-30, 90));
                    $paidDate = null;

                    if ($status === 'paid') {
                        $paidDate = $dueDate->copy()->addDays(rand(0, 10));
                    }

                    FinanceRecord::create([
                        'student_id' => $user->id,
                        'amount' => rand(200000, 5000000),
                        'payment_type' => $paymentType,
                        'payment_status' => $status,
                        'due_date' => $dueDate,
                        'paid_date' => $paidDate,
                        'description' => $paymentType . ' payment for ' . $user->name,
                        'category' => ucfirst($paymentType) . ' Fee',
                        'receipt_number' => 'RCP-' . str_pad($user->id * 10 + $i, 4, '0', STR_PAD_LEFT),
                        'payment_method' => ['cash', 'bank_transfer', 'credit_card', 'gopay', 'dana', 'ovo'][array_rand(['cash', 'bank_transfer', 'credit_card', 'gopay', 'dana', 'ovo'])],
                        'notes' => 'Payment for ' . $paymentType . ' fee'
                    ]);
                }
            }
        }
    }
}
