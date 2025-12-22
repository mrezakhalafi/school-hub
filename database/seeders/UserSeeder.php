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

        if (!User::where('email', 'mrezakhalafi@gmail.com')->exists()) {
            User::factory()->create([
                'name' => 'M Reza Khalafi',
                'email' => 'mrezakhalafi@example.com',
                'password' => Hash::make('1S2d3T4e5L'),
                'role' => 'admin',
            ]);
        }

        if (!User::where('email', 'admin@gmail.com')->exists()) {
            User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('11111'),
                'role' => 'admin',
            ]);
        }

        // Create teacher user if not exists
        if (!User::where('email', 'teacher@gmail.com')->exists()) {
            User::factory()->create([
                'name' => 'Teacher User',
                'email' => 'teacher@gmail.com',
                'password' => Hash::make('11111'),
                'role' => 'teacher',
            ]);
        }

        // Create student user if not exists
        if (!User::where('email', 'student@gmail.com')->exists()) {
            User::factory()->create([
                'name' => 'Student User',
                'email' => 'student@gmail.com',
                'password' => Hash::make('11111'),
                'role' => 'student',
            ]);
        }

        // Create security guard user if not exists
        if (!User::where('email', 'security_guard@gmail.com')->exists()) {
            User::factory()->create([
                'name' => 'Security Guard User',
                'email' => 'security_guard@gmail.com',
                'password' => Hash::make('11111'),
                'role' => 'security_guard',
            ]);
        }

        // Create office boy user if not exists
        if (!User::where('email', 'office_boy@gmail.com')->exists()) {
            User::factory()->create([
                'name' => 'Office Boy User',
                'email' => 'office_boy@gmail.com',
                'password' => Hash::make('11111'),
                'role' => 'office_boy',
            ]);
        }
    }
}
