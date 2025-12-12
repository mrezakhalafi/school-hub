<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all students and all classes
        $students = \App\Models\Student::all();
        $classes = \App\Models\ClassModel::all();

        // Check if we have students and classes
        if ($students->count() === 0 || $classes->count() === 0) {
            $this->command->info('No students or classes found to assign.');
            return;
        }

        // Randomly assign each student to a class
        foreach ($students as $student) {
            $randomClass = $classes->random();
            $student->class_id = $randomClass->id;
            $student->save();
        }

        $this->command->info('Successfully assigned ' . $students->count() . ' students to ' . $classes->count() . ' classes randomly.');
    }
}
