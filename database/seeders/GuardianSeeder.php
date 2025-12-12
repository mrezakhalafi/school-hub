<?php

namespace Database\Seeders;

use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Database\Seeder;

class GuardianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all created students
        $students = Student::all();

        // Create 1-2 guardians for each student
        $firstNames = ['Suharto', 'Siti', 'Bambang', 'Dewi', 'Agus', 'Lina', 'Rudi', 'Mutiara', 'Haryanto', 'Ratna'];
        $lastNames = ['Wijaya', 'Sari', 'Kurniawan', 'Utami', 'Santoso', 'Pratiwi', 'Hidayat', 'Lestari', 'Saputra', 'Puspita'];
        $relationships = ['father', 'mother', 'guardian'];

        foreach ($students as $index => $student) {
            // Each student gets 1-2 guardians
            $numGuardians = rand(1, 2);

            for ($i = 0; $i < $numGuardians; $i++) {
                $firstName = $firstNames[array_rand($firstNames)];
                $lastName = $lastNames[array_rand($lastNames)];
                $relationship = $relationships[array_rand($relationships)];

                Guardian::create([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => strtolower($firstName . '.' . $lastName . $index . $i . '@example.com'),
                    'phone' => '+62' . rand(1000000000, 9999999999),
                    'address' => 'Alamat wali ' . ($index+1),
                    'relationship' => $relationship,
                    'student_id' => $student->id,
                ]);
            }
        }
    }
}
