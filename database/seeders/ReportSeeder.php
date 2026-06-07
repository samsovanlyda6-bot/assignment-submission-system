<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('reports')->insert([
            [
                'title' => 'Student Performance Report',
                'generated_by' => 2,
                'data' => json_encode(['total_students' => 1, 'average_score' => 85.5]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}