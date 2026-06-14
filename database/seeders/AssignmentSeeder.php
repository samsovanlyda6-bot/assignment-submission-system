<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AssignmentSeeder extends Seeder
{
    public function run(): void
    {
        $assignments = [
            [
                'assignment_id' => 1,
                'course_id' => 1,
                'title' => 'BSA',
                'description' => 'Create a calculator using PHP with basic arithmetic operations',
                'total_marks' => 100.00,
                'start_date' => Carbon::now(),
                'due_date' => Carbon::now()->addDays(7),
                'allow_late_submission' => true,
                'created_by' => 2, // John Teacher's user_id
                'status' => 'Published',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'assignment_id' => 2,
                'course_id' => 2,
                'title' => 'DSAS',
                'description' => 'Implement a binary search tree with insert, delete, and search operations',
                'total_marks' => 100.00,
                'start_date' => Carbon::now(),
                'due_date' => Carbon::now()->addDays(14),
                'allow_late_submission' => true,
                'created_by' => 2,
                'status' => 'Published',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'assignment_id' => 3,
                'course_id' => 3,
                'title' => 'Laravel Blog Project',
                'description' => 'Create a complete blog system using Laravel framework',
                'total_marks' => 100.00,
                'start_date' => Carbon::now(),
                'due_date' => Carbon::now()->addDays(21),
                'allow_late_submission' => false,
                'created_by' => 2,
                'status' => 'Published',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($assignments as $assignment) {
            $exists = DB::table('assignments')->where('assignment_id', $assignment['assignment_id'])->exists();
            if (!$exists) {
                DB::table('assignments')->insert($assignment);
            }
        }

        $this->command->info('Assignments seeded successfully!');
    }
}
