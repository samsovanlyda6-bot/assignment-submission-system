<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'user_id' => 1,
                'role_id' => 1,
                'full_name' => 'Admin User',
                'email' => 'admin@example.com',
                'phone' => '1234567890',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'role_id' => 2,
                'full_name' => 'John Teacher',
                'email' => 'teacher@example.com',
                'phone' => '1234567891',
                'username' => 'teacher_john',
                'password' => Hash::make('password'),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'role_id' => 3,
                'full_name' => 'Jane Student',
                'email' => 'student@example.com',
                'phone' => '1234567892',
                'username' => 'student_jane',
                'password' => Hash::make('password'),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        foreach ($users as $user) {
            $exists = DB::table('users')->where('user_id', $user['user_id'])->exists();
            if (!$exists) {
                DB::table('users')->insert($user);
            }
        }
        
        $this->command->info('Users seeded successfully!');
    }
}