<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user can log in with a valid email and password.
     */
    public function test_user_can_login_with_email()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'employee_id' => null,
            'password' => Hash::make('secret123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'secret123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'name',
                    'email',
                    'employee_id',
                ],
                'token',
            ]);
    }

    /**
     * Test user can log in with a valid employee ID and password.
     */
    public function test_user_can_login_with_employee_id()
    {
        $user = User::create([
            'name' => 'Employee User',
            'email' => 'emp12345@bsti.gov.bd',
            'employee_id' => '12345',
            'password' => Hash::make('secret123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => '12345',
            'password' => 'secret123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'name',
                    'email',
                    'employee_id',
                ],
                'token',
            ]);
    }

    /**
     * Test log in fails with invalid credentials.
     */
    public function test_login_fails_with_invalid_credentials()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('secret123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    /**
     * Test authenticated user can log out.
     */
    public function test_user_can_logout()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('secret123'),
        ]);

        $token = $user->createToken('test_token')->plainTextToken;

        // Logout request with Authorization header
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Successfully logged out.',
            ]);

        // Assert token is deleted in the database
        $this->assertCount(0, $user->tokens()->get());
    }
}
