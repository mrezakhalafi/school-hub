<?php

namespace Database\Seeders;

use App\Models\SchoolEvent;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 events
        $events = [
            [
                'title' => 'Science Fair 2025',
                'description' => 'Annual science fair showcasing students\' innovative projects and experiments.',
                'start_date' => now()->addDays(7),
                'location' => 'School Auditorium',
                'event_type' => 'academic',
                'is_published' => true,
            ],
            [
                'title' => 'Annual Sports Day',
                'description' => 'A day filled with various sports competitions for all grade levels.',
                'start_date' => now()->addDays(14),
                'location' => 'School Sports Field',
                'event_type' => 'sports',
                'is_published' => true,
            ],
            [
                'title' => 'Art Exhibition',
                'description' => 'Display of students\' artwork including paintings, sculptures, and digital art.',
                'start_date' => now()->addDays(21),
                'location' => 'School Library',
                'event_type' => 'arts',
                'is_published' => true,
            ],
            [
                'title' => 'Parent-Teacher Meeting',
                'description' => 'Quarterly meeting between parents and teachers to discuss student progress.',
                'start_date' => now()->addDays(5),
                'location' => 'Classrooms',
                'event_type' => 'academic',
                'is_published' => true,
            ],
            [
                'title' => 'School Play: Cinderella',
                'description' => 'Drama performance by the school\'s theater club.',
                'start_date' => now()->addDays(30),
                'location' => 'School Theater',
                'event_type' => 'arts',
                'is_published' => true,
            ],
            [
                'title' => 'Mathematics Olympiad',
                'description' => 'Competition for students excelling in mathematics.',
                'start_date' => now()->addDays(10),
                'location' => 'Mathematics Room',
                'event_type' => 'academic',
                'is_published' => true,
            ],
            [
                'title' => 'Debate Competition',
                'description' => 'Inter-class debate competition on current social issues.',
                'start_date' => now()->addDays(25),
                'location' => 'Conference Room',
                'event_type' => 'extracurricular',
                'is_published' => true,
            ],
            [
                'title' => 'Cultural Festival',
                'description' => 'Celebration of diverse cultures with food, music, and dance performances.',
                'start_date' => now()->addDays(18),
                'location' => 'School Grounds',
                'event_type' => 'other',
                'is_published' => true,
            ],
            [
                'title' => 'School Picnic',
                'description' => 'Fun day out for students and teachers at the local park.',
                'start_date' => now()->addDays(35),
                'location' => 'City Park',
                'event_type' => 'other',
                'is_published' => true,
            ],
            [
                'title' => 'Robotics Workshop',
                'description' => 'Hands-on workshop to build and program robots.',
                'start_date' => now()->addDays(12),
                'location' => 'Science Lab',
                'event_type' => 'extracurricular',
                'is_published' => true,
            ],
        ];

        foreach ($events as $eventData) {
            SchoolEvent::create($eventData);
        }
    }
}
