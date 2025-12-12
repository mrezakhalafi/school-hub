<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 20 teachers
        $teachers = [
            ['first_name' => 'Siti', 'last_name' => 'Aminah', 'email' => 'siti.aminah@example.com', 'gender' => 'female'],
            ['first_name' => 'Budi', 'last_name' => 'Santoso', 'email' => 'budi.santoso@example.com', 'gender' => 'male'],
            ['first_name' => 'Rina', 'last_name' => 'Lestari', 'email' => 'rina.lestari@example.com', 'gender' => 'female'],
            ['first_name' => 'Andi', 'last_name' => 'Pratama', 'email' => 'andi.pratama@example.com', 'gender' => 'male'],
            ['first_name' => 'Dewi', 'last_name' => 'Kusuma', 'email' => 'dewi.kusuma@example.com', 'gender' => 'female'],
            ['first_name' => 'Rizki', 'last_name' => 'Hidayat', 'email' => 'rizki.hidayat@example.com', 'gender' => 'male'],
            ['first_name' => 'Maya', 'last_name' => 'Sari', 'email' => 'maya.sari@example.com', 'gender' => 'female'],
            ['first_name' => 'Agus', 'last_name' => 'Setiawan', 'email' => 'agus.setiawan@example.com', 'gender' => 'male'],
            ['first_name' => 'Lina', 'last_name' => 'Puspita', 'email' => 'lina.puspita@example.com', 'gender' => 'female'],
            ['first_name' => 'Fajar', 'last_name' => 'Nugroho', 'email' => 'fajar.nugroho@example.com', 'gender' => 'male'],
            ['first_name' => 'Tina', 'last_name' => 'Wulandari', 'email' => 'tina.wulandari@example.com', 'gender' => 'female'],
            ['first_name' => 'Hendra', 'last_name' => 'Kurniawan', 'email' => 'hendra.kurniawan@example.com', 'gender' => 'male'],
            ['first_name' => 'Nina', 'last_name' => 'Febrianti', 'email' => 'nina.febrianti@example.com', 'gender' => 'female'],
            ['first_name' => 'Yudi', 'last_name' => 'Sulistyo', 'email' => 'yudi.sulistyo@example.com', 'gender' => 'male'],
            ['first_name' => 'Siska', 'last_name' => 'Anggraini', 'email' => 'siska.anggraini@example.com', 'gender' => 'female'],
            ['first_name' => 'Ari', 'last_name' => 'Gunawan', 'email' => 'ari.gunawan@example.com', 'gender' => 'male'],
            ['first_name' => 'Eka', 'last_name' => 'Susanti', 'email' => 'eka.susanti@example.com', 'gender' => 'female'],
            ['first_name' => 'Dian', 'last_name' => 'Kurnia', 'email' => 'dian.kurnia@example.com', 'gender' => 'female'],
            ['first_name' => 'Rian', 'last_name' => 'Prasetyo', 'email' => 'rian.prasetyo@example.com', 'gender' => 'male'],
            ['first_name' => 'Yuni', 'last_name' => 'Larasati', 'email' => 'yuni.larasati@example.com', 'gender' => 'female'],
        ];

        foreach ($teachers as $teacherData) {
            Teacher::create($teacherData);
        }
    }
}
