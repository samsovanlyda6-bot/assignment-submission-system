<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Check if roles already exist
        $roles = [
            ['role_id' => 1, 'role_name' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 2, 'role_name' => 'teacher', 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 3, 'role_name' => 'student', 'created_at' => now(), 'updated_at' => now()],
        ];
        
        foreach ($roles as $role) {
            $exists = DB::table('roles')->where('role_id', $role['role_id'])->exists();
            if (!$exists) {
                DB::table('roles')->insert($role);
            }
        }
        
        $this->command->info('Roles seeded successfully!');
    }
}