<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $enrollments = [
            ['student_id' => 3, 'course_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['student_id' => 3, 'course_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['student_id' => 3, 'course_id' => 3, 'created_at' => now(), 'updated_at' => now()],
        ];
        
        foreach ($enrollments as $enrollment) {
            DB::table('enrollments')->insert($enrollment);
        }
        
        $this->command->info('Enrollments seeded successfully!');
    }
}