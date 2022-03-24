<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    public function testRequiresEmailAndPass()
    {
        $this->json('POST', 'api/auth/login')
             ->assertStatus(422)
             ->assertJson([
                 'message' => 'The given data was invalid.',
                 'errors' => [
                     'email' => ['The email field is required.'],
                     'password' => ['The password field is required.'],
                 ]
             ]);
    }

    public function testUserLoginSuccessfully()
    {

        $user = User::factory()->create([
            'password' => bcrypt('12345678')
        ]);

        $payload = [
            'email' => $user->email,
            'password' => '12345678',
        ];

        $this->json('POST', 'api/auth/login', $payload)
             ->assertStatus(200)
             ->assertJsonStructure([
                 'token' => [
                     'access_token',
                     'token_type'
                 ],
                 'user' => [
                    'name',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at'
                 ]
             ]);
    }
}