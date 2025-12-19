<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HealthRecord;
use App\Models\Student;

class HealthRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::all();

        if ($students->count() > 0) {
            // Create a fixed number of health records (not one per student)
            $totalRecords = 5; // Fixed number as requested

            for ($i = 0; $i < $totalRecords; $i++) {
                $randomStudent = $students->random(); // Pick a random student

                HealthRecord::create([
                    'student_id' => $randomStudent->id,
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
