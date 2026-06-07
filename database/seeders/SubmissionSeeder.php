<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubmissionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('submissions')->insert([
            [
                'assignment_id' => 1,
                'student_id' => 3,
                'submitted_at' => now(),
                'file_path' => 'submissions/assignment1.pdf',
                'status' => 'submitted',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}