<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('courses')->insert([
            [
                'course_id' => 1,
                'course_name' => 'Introduction to Programming',
                'course_code' => 'CS101',
                'description' => 'Learn basic programming concepts using PHP',
                'created_by' => 2,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 2,
                'course_name' => 'Data Structures',
                'course_code' => 'CS201',
                'description' => 'Advanced data structures and algorithms',
                'created_by' => 2,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 3,
                'course_name' => 'Web Development',
                'course_code' => 'WEB101',
                'description' => 'HTML, CSS, JavaScript and Laravel',
                'created_by' => 2,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
