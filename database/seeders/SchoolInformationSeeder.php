<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SchoolInformation;

class SchoolInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schoolInfo = SchoolInformation::first();
        if ($schoolInfo) {
            $schoolInfo->update([
                'school_name' => 'SMAN 1 Jakarta',
                'head_of_school' => 'Dr. Ahmad Santoso',
                'location' => 'Jl. Merdeka No. 1, Jakarta Pusat',
                'history' => 'Sekolah Menengah Atas Negeri 1 Jakarta didirikan pada tahun 1950 sebagai salah satu sekolah unggulan di Jakarta. Sekolah ini memiliki sejarah panjang dalam mencetak lulusan yang berprestasi di berbagai bidang.',
                'building_features' => 'Gedung sekolah terdiri dari 4 lantai dengan fasilitas ruang kelas modern, laboratorium sains, perpustakaan digital, aula serbaguna, dan lapangan olahraga.',
                'extracurricular_activities' => 'Sekolah menyediakan berbagai kegiatan ekstrakurikuler seperti Paskibra, Pramuka, PMR, Olahraga (sepak bola, bulu tangkis, basket), Seni (teater, musik, tari), dan Jurnalistik.',
                'accreditation' => 'A',
                'founding_year' => 1950,
                'student_capacity' => 1200,
            ]);
        } else {
            SchoolInformation::create([
                'school_name' => 'SMAN 1 Jakarta',
                'head_of_school' => 'Dr. Ahmad Santoso',
                'location' => 'Jl. Merdeka No. 1, Jakarta Pusat',
                'history' => 'Sekolah Menengah Atas Negeri 1 Jakarta didirikan pada tahun 1950 sebagai salah satu sekolah unggulan di Jakarta. Sekolah ini memiliki sejarah panjang dalam mencetak lulusan yang berprestasi di berbagai bidang.',
                'building_features' => 'Gedung sekolah terdiri dari 4 lantai dengan fasilitas ruang kelas modern, laboratorium sains, perpustakaan digital, aula serbaguna, dan lapangan olahraga.',
                'extracurricular_activities' => 'Sekolah menyediakan berbagai kegiatan ekstrakurikuler seperti Paskibra, Pramuka, PMR, Olahraga (sepak bola, bulu tangkis, basket), Seni (teater, musik, tari), dan Jurnalistik.',
                'accreditation' => 'A',
                'founding_year' => 1950,
                'student_capacity' => 1200,
            ]);
        }
    }
}
