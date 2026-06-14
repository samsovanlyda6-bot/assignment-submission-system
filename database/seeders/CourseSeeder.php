<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // Temporarily disable foreign key checks to allow truncation
        Schema::disableForeignKeyConstraints();
        DB::table('courses')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('courses')->insert([
            [
                'course_id' => 1,
                'course_name' => 'Basic Programming Languge',
                'course_code' => 'IT-001',
                'description' => 'Learn basic programming concepts using PHP',
                'created_by' => 2,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 2,
                'course_name' => 'Data Structures and System Analysis',
                'course_code' => 'IT-002',
                'description' => 'Advanced data structures and algorithms',
                'created_by' => 2,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 3,
                'course_name' => 'Web Development',
                'course_code' => 'IT-003',
                'description' => 'HTML, CSS, JavaScript and Laravel',
                'created_by' => 2,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 4,
                'course_name' => 'Object Oriented Programming Languge',
                'course_code' => 'IT-004',
                'description' => 'Learn basic programming concepts using PHP',
                'created_by' => 2,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
