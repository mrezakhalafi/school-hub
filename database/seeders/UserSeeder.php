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
        // Create admin user if not exists
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
        }

        // Create teacher user if not exists
        if (!User::where('email', 'teacher@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Teacher User',
                'email' => 'teacher@example.com',
                'password' => Hash::make('11111'),
                'role' => 'teacher',
            ]);
        }

        // Create student user if not exists
        if (!User::where('email', 'student@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Student User',
                'email' => 'student@example.com',
                'password' => Hash::make('11111'),
                'role' => 'student',
            ]);
        }
    }
}
