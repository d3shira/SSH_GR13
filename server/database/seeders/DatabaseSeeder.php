<?php

namespace Database\Seeders;

use App\Models\Users;
use App\Models\Role;
use App\Models\Ability;
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

        $adminRole = Role::firstOrCreate(['role_name' => 'admin']);
        $userRole = Role::firstOrCreate(['role_name' => 'client']);
        $staffRole = Role::firstOrCreate(['role_name' => 'staff']);


       // Create abilities
       $fillForm = Ability::create(['ability_name' => 'fill-form']);
       $createPost = Ability::create(['ability_name' => 'create-post']);
       $editPost = Ability::create(['ability_name' => 'edit-post']);
       $deletePost = Ability::create(['ability_name' => 'delete-post']);
       $viewContent = Ability::create(['ability_name' => 'view-content']);
       $manageContent = Ability::create(['ability_name' => 'manage-content']);
       

       // Create users
       Users::factory()->create([
           'first_name' => 'Admin',
           'last_name' => 'User',
           'username' => 'admin',
           'email' => 'admin@example.com',
           'password' => bcrypt('password'),
           'role_id' => $adminRole->id,
           'ability_id' => $createPost->id,
       ]);

       Users::factory()->create([
           'first_name' => 'Client',
           'last_name' => 'User',
           'username' => 'client',
           'email' => 'client@example.com',
           'password' => bcrypt('password'),
           'role_id' => $userRole->id,
           'ability_id' => $viewContent->id,
       ]);

       Users::factory()->create([
           'first_name' => 'Staff',
           'last_name' => 'Member',
           'username' => 'staff',
           'email' => 'staff@example.com',
           'password' => bcrypt('password'),
           'role_id' => $staffRole->id,
           'ability_id' => $manageContent->id,
       ]);
    }
}
