<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterUser()
    {
        $response = $this->postJson('/register', [
            'first_name' => 'Elena',
            'last_name' => 'Dushi',
            'username' => 'elenadushi',
            'email' => 'elena@example.com',
            'phone' => '123456789',
            'password' => 'password123',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['message', 'data' => ['id', 'first_name', 'last_name', 'username', 'email', 'phone', 'role']]);

        $this->assertDatabaseHas('users', [
            'username' => 'elenadushi',
            'email' => 'elena@example.com',
        ]);
    }

    public function testLoginUser()
    {
        $user = Users::factory()->create([
            'username' => 'elenadushi',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/login', [
            'username' => 'elenadushi',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['access_token', 'token_type', 'expires_in', 'user', 'redirect']);
    }

    public function testRegisterStaff()
    {
        $response = $this->postJson('/registerStaff', [
            'first_name' => 'Nora',
            'last_name' => 'Leka',
            'username' => 'noroleka',
            'email' => 'nora@example.com',
            'phone' => '987654321',
            'job_position' => 'Manager',
            'password' => 'password123',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['message', 'data' => ['id', 'first_name', 'last_name', 'username', 'email', 'phone', 'role']]);

        $this->assertDatabaseHas('users', [
            'username' => 'noroleka',
            'email' => 'nora@example.com',
            'role' => 'staff',
        ]);

        $this->assertDatabaseHas('sales_agents', [
            'job_position' => 'Manager',
        ]);
    }

    public function testGetAuthenticatedUser()
    {
        $user = Users::factory()->create();

        $token = auth()->login($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->getJson('/user');

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $user->id,
                     'first_name' => $user->first_name,
                     'last_name' => $user->last_name,
                     'username' => $user->username,
                     'email' => $user->email,
                 ]);
    }

    public function testLogoutUser()
    {
        $user = Users::factory()->create();

        $token = auth()->login($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson('/logout');

        $response->assertStatus(200)
                 ->assertJson(['message' => 'User successfully logged out']);
    }
}


