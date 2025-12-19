<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user

        // User::factory()->create([
        //     'name' => 'M Reza Khalafi',
        //     'email' => 'mrezakhalafi@gmail.com',
        //     'password' => Hash::make('11111'),
        //     'role' => 'admin',
        // ]);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create teacher user
        User::factory()->create([
            'name' => 'Teacher User',
            'email' => 'teacher@example.com',
            'password' => Hash::make('11111'),
            'role' => 'teacher',
        ]);

        // Create student user
        User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@example.com',
            'password' => Hash::make('11111'),
            'role' => 'student',
        ]);
    }
}
