<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('grades')->insert([
            [
                'submission_id' => 1,
                'student_id' => 3,
                'assignment_id' => 1,
                'score' => 85.5,
                'feedback' => 'Good work, but could improve',
                'graded_by' => 2,
                'graded_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}