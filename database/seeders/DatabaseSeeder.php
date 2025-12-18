<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a default user for testing
        // User::factory()->create([
        //     'name' => 'Admin User',
        //     'email' => 'admin@example.com',
        // ]);

         User::factory()->create([
            'name' => 'M Reza Khalafi',
            'email' => 'mrezakhalafi@gmail.com',
        ]);

        // Seed data in the correct order due to relationships
        $this->call([
            ClassSeeder::class,
            TeacherSeeder::class,
            StudentSeeder::class,
            ParentSeeder::class,
            EventSeeder::class,
            SecurityGuardSeeder::class,
            OfficeBoySeeder::class,
            ScheduleSeeder::class,
        ]);
    }
}
