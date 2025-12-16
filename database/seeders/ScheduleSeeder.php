<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\ClassModel;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define subjects for schedule
        $subjects = [
            'Mathematics', 'Indonesian Language', 'English Language', 'Science',
            'Social Studies', 'Religious Studies', 'Physical Education',
            'Art and Culture', 'Technology Studies', 'Civics', 'Economics', 'Biology',
            'Physics', 'Chemistry', 'History', 'Geography', 'Computer Science'
        ];

        // Define days of the week
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        // Get all classes
        $classes = ClassModel::all();

        // Get all teachers
        $teachers = Teacher::all();

        // For each class, create a schedule
        foreach ($classes as $class) {
            // Create schedules for each day
            foreach ($days as $day) {
                // Create multiple subjects per day with different hours
                for ($hour = 7; $hour <= 14; $hour++) {
                    // Randomly select a subject and teacher
                    $subject = $subjects[array_rand($subjects)];
                    $teacher = $teachers->isNotEmpty() ? $teachers->random() : null;

                    // Create a new schedule
                    Schedule::create([
                        'class_id' => $class->id,
                        'day' => $day,
                        'hour' => $hour,
                        'subject' => $subject,
                        'teacher_id' => $teacher ? $teacher->id : null,
                    ]);
                }
            }
        }

        // For some classes, add more variety to make the schedule more realistic
        $allSchedules = Schedule::all();

        // Update some schedules to make them more realistic (not every hour has the same subject)
        foreach ($classes as $class) {
            // Clear all schedules for this class to create a more realistic schedule
            Schedule::where('class_id', $class->id)->delete();

            // Create a realistic schedule for the class
            $this->createRealisticSchedule($class, $subjects, $teachers);
        }
    }

    private function createRealisticSchedule($class, $subjects, $teachers)
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        // Define a realistic schedule pattern for each day
        $schedulePattern = [
            'Monday' => [
                7 => ['subject' => 'Mathematics', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                8 => ['subject' => 'Indonesian Language', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                9 => ['subject' => 'English Language', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                10 => ['subject' => 'Science', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                11 => ['subject' => 'Break', 'teacher' => null],
                12 => ['subject' => 'Social Studies', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                13 => ['subject' => 'Religious Studies', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                14 => ['subject' => 'Physical Education', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
            ],
            'Tuesday' => [
                7 => ['subject' => 'Economics', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                8 => ['subject' => 'Civics', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                9 => ['subject' => 'Computer Science', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                10 => ['subject' => 'Biology', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                11 => ['subject' => 'Break', 'teacher' => null],
                12 => ['subject' => 'Physics', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                13 => ['subject' => 'Chemistry', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                14 => ['subject' => 'Art and Culture', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
            ],
            'Wednesday' => [
                7 => ['subject' => 'History', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                8 => ['subject' => 'Geography', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                9 => ['subject' => 'Mathematics', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                10 => ['subject' => 'English Language', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                11 => ['subject' => 'Break', 'teacher' => null],
                12 => ['subject' => 'Science', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                13 => ['subject' => 'Indonesian Language', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                14 => ['subject' => 'Technology Studies', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
            ],
            'Thursday' => [
                7 => ['subject' => 'Religious Studies', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                8 => ['subject' => 'Civics', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                9 => ['subject' => 'Economics', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                10 => ['subject' => 'Biology', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                11 => ['subject' => 'Break', 'teacher' => null],
                12 => ['subject' => 'Physics', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                13 => ['subject' => 'Chemistry', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                14 => ['subject' => 'Physical Education', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
            ],
            'Friday' => [
                7 => ['subject' => 'Art and Culture', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                8 => ['subject' => 'Computer Science', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                9 => ['subject' => 'Mathematics', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                10 => ['subject' => 'Social Studies', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                11 => ['subject' => 'Break', 'teacher' => null],
                12 => ['subject' => 'English Language', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                13 => ['subject' => 'Science', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
                14 => ['subject' => 'Technology Studies', 'teacher' => $teachers->isNotEmpty() ? $teachers->random() : null],
            ]
        ];

        // Create the schedules based on the pattern
        foreach ($schedulePattern as $day => $hours) {
            foreach ($hours as $hour => $data) {
                if ($data['subject'] !== 'Break') {
                    Schedule::create([
                        'class_id' => $class->id,
                        'day' => $day,
                        'hour' => $hour,
                        'subject' => $data['subject'],
                        'teacher_id' => $data['teacher'] ? $data['teacher']->id : null,
                    ]);
                }
            }
        }
    }
}
