<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('notifications')->insert([
            [
                'user_id' => 3,
                'title' => 'Assignment Graded',
                'message' => 'Your assignment has been graded',
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}