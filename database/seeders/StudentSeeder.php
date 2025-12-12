<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\ClassModel;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all created classes
        $classes = ClassModel::all();

        // Create 20 students for each class (12 classes * 20 = 240 students)
        $firstNames = ['Ahmad', 'Budi', 'Citra', 'Dian', 'Eko', 'Fika', 'Gita', 'Hendra', 'Indah', 'Joko',
                      'Kartika', 'Lukman', 'Mira', 'Nanda', 'Oka', 'Putri', 'Rina', 'Sigit', 'Tina', 'Umar'];
        $lastNames = ['Saputra', 'Wijaya', 'Lestari', 'Pratama', 'Sulistyo', 'Kusuma', 'Hidayat', 'Purnama',
                     'Sari', 'Kurniawan', 'Wibowo', 'Febrianto', 'Susanto', 'Anggraini', 'Mandala', 'Wulandari',
                     'Setiawan', 'Gunawan', 'Puspita', 'Prasetyo'];

        $classCount = 0;
        foreach ($classes as $class) {
            for ($i = 0; $i < 20; $i++) {
                $firstName = $firstNames[array_rand($firstNames)];
                $lastName = $lastNames[array_rand($lastNames)];

                Student::create([
                    'student_id' => sprintf('STU%04d', ($classCount * 20) + $i + 1),
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'gender' => (rand(0, 1) == 0) ? 'male' : 'female',
                    'class_id' => $class->id,
                    'address' => 'Alamat siswa ' . ($i+1)
                ]);
            }
            $classCount++;
        }
    }
}
