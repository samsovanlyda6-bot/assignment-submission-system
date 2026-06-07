<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CourseSeeder::class,
            EnrollmentSeeder::class,
            AssignmentSeeder::class,
            // Add other seeders as we fix them
        ]);
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('All seeders completed successfully!');
    }
}