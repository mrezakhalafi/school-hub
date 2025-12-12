<?php

namespace Database\Seeders;

use App\Models\ClassModel;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 6 classes: 10, 11, 12 for both IPA and IPS
        $classes = [
            // Class 10
            ['name' => '10 IPA 1', 'level' => '10', 'major' => 'IPA', 'section' => '1'],
            ['name' => '10 IPA 2', 'level' => '10', 'major' => 'IPA', 'section' => '2'],
            ['name' => '10 IPS 1', 'level' => '10', 'major' => 'IPS', 'section' => '1'],
            ['name' => '10 IPS 2', 'level' => '10', 'major' => 'IPS', 'section' => '2'],

            // Class 11
            ['name' => '11 IPA 1', 'level' => '11', 'major' => 'IPA', 'section' => '1'],
            ['name' => '11 IPA 2', 'level' => '11', 'major' => 'IPA', 'section' => '2'],
            ['name' => '11 IPS 1', 'level' => '11', 'major' => 'IPS', 'section' => '1'],
            ['name' => '11 IPS 2', 'level' => '11', 'major' => 'IPS', 'section' => '2'],

            // Class 12
            ['name' => '12 IPA 1', 'level' => '12', 'major' => 'IPA', 'section' => '1'],
            ['name' => '12 IPA 2', 'level' => '12', 'major' => 'IPA', 'section' => '2'],
            ['name' => '12 IPS 1', 'level' => '12', 'major' => 'IPS', 'section' => '1'],
            ['name' => '12 IPS 2', 'level' => '12', 'major' => 'IPS', 'section' => '2'],
        ];

        foreach ($classes as $classData) {
            ClassModel::create($classData);
        }
    }
}
