<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HealthRecord;
use App\Models\User;

class HealthRecordSeeder extends Seeder
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
                HealthRecord::create([
                    'student_id' => $student->id,
                    'height' => rand(140, 170),
                    'weight' => rand(40, 70) + (rand(0, 99) / 100),
                    'blood_pressure' => rand(100, 140) . '/' . rand(60, 90),
                    'vision_test_result' => rand(0, 1) ? '20/20' : '20/40',
                    'hearing_test_result' => 'Normal',
                    'dental_health' => rand(0, 1) ? 'Good' : 'Needs attention',
                    'allergies' => rand(0, 2) > 0 ? ['Dust', 'Pollen', 'Food'] : null,
                    'medical_conditions' => rand(0, 3) > 2 ? ['Asthma', 'Epilepsy'] : null,
                    'medications' => rand(0, 2) > 1 ? 'Daily vitamins' : null,
                    'emergency_contact' => 'Parent: John Doe (081234567890)',
                    'immunization_records' => ['DPT', 'Polio', 'MMR', 'Hepatitis B'],
                    'date_checked' => now()->subDays(rand(0, 180)),
                    'checked_by' => 'Dr. Smith, MD'
                ]);
            }
        } else {
            // If no students exist, create a few health records for any user with student role
            $users = User::where('role', 'student')->take(5)->get();
            foreach ($users as $index => $user) {
                HealthRecord::create([
                    'student_id' => $user->id,
                    'height' => rand(140, 170),
                    'weight' => rand(40, 70) + (rand(0, 99) / 100),
                    'blood_pressure' => rand(100, 140) . '/' . rand(60, 90),
                    'vision_test_result' => rand(0, 1) ? '20/20' : '20/40',
                    'hearing_test_result' => 'Normal',
                    'dental_health' => rand(0, 1) ? 'Good' : 'Needs attention',
                    'allergies' => rand(0, 2) > 0 ? ['Dust', 'Pollen', 'Food'] : null,
                    'medical_conditions' => rand(0, 3) > 2 ? ['Asthma', 'Epilepsy'] : null,
                    'medications' => rand(0, 2) > 1 ? 'Daily vitamins' : null,
                    'emergency_contact' => 'Parent: John Doe (081234567890)',
                    'immunization_records' => ['DPT', 'Polio', 'MMR', 'Hepatitis B'],
                    'date_checked' => now()->subDays(rand(0, 180)),
                    'checked_by' => 'Dr. Smith, MD'
                ]);
            }
        }
    }
}
