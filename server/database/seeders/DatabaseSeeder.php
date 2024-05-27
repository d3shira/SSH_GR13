<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Users;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Users::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $adminRole = Role::firstOrCreate(['role_name' => 'admin']);
        $userRole = Role::firstOrCreate(['role_name' => 'client']);
        $staffRole = Role::firstOrCreate(['role_name' => 'staff']);


          // Create users
       Users::factory()->create([
        'first_name' => 'Admin',
        'last_name' => 'User',
        'username' => 'admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
        'role_id' => $adminRole->id,
        
    ]);

    Users::factory()->create([
        'first_name' => 'Client',
        'last_name' => 'User',
        'username' => 'client',
        'email' => 'client@example.com',
        'password' => bcrypt('password'),
        'role_id' => $userRole->id,
        
    ]);

    Users::factory()->create([
        'first_name' => 'Staff',
        'last_name' => 'Member',
        'username' => 'staff',
        'email' => 'staff@example.com',
        'password' => bcrypt('password'),
        'role_id' => $staffRole->id,
        
    ]);

    }
}
