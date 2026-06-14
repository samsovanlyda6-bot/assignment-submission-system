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
                'email' => 'admin@gmail.com',
                'phone' => '0884491888',
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
                'email' => 'teacher@gmail.com',
                'phone' => '0884491887',
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
                'email' => 'student@gmail.com',
                'phone' => '0884491886',
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
