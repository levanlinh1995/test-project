<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    public function testRegisterSuccessfully()
    {
        $faker = \Faker\Factory::create();

        $payload = [
            'email' => $faker->email,
            'password' => '12345678',
        ];

        $this->json('POST', 'api/register', $payload)
             ->assertStatus(201);
    }

    public function testRequiresEmailAndPass()
    {
        $this->json('POST', 'api/register')
             ->assertStatus(422)
             ->assertJson([
                 'message' => 'The given data was invalid.',
                 'errors' => [
                     'email' => ['The email field is required.'],
                     'password' => ['The password field is required.'],
                 ]
             ]);
    }

    public function testEmailExists()
    {
        $user = User::factory()->create([
            'password' => bcrypt('12345678')
        ]);

        $payload = [
            'email' => $user->email,
            'password' => '12345678',
        ];

        $this->json('POST', 'api/register', $payload)
             ->assertStatus(422)
             ->assertJson([
                 'message' => 'The given data was invalid.',
                 'errors' => [
                     'email' => ['The email has already been taken.'],
                 ]
             ]);
    }
}
