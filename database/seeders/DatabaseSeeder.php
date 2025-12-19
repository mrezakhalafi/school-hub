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
        // Call UserSeeder first to create default users
        $this->call([
            UserSeeder::class,
            ClassSeeder::class,
            TeacherSeeder::class,
            StudentSeeder::class,
            ParentSeeder::class,
            EventSeeder::class,
            SecurityGuardSeeder::class,
            OfficeBoySeeder::class,
            ScheduleSeeder::class,
            HealthRecordSeeder::class,
            FinanceRecordSeeder::class,
        ]);
    }
}
