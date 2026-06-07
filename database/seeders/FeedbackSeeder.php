<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeedbackSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('feedback')->insert([
            [
                'submission_id' => 1,
                'teacher_id' => 2,
                'student_id' => 3,
                'comments' => 'Well structured code, good documentation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}