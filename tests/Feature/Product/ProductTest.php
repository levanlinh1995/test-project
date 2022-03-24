<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductTest extends TestCase
{
    public function testArticlesAreCreatedCorrectly()
    {
        $faker = \Faker\Factory::create();

        $user = User::factory()->create();
        $token = $user->createToken('my-auth-token')->plainTextToken;

        $payload = [
            'name' => 'test',
            'sku' => Str::random(10),
            'price' => $faker->randomNumber(),
            'qty' => $faker->numberBetween(1000,9000),
            'unit' => 'Carton',
            'status' => $faker->numberBetween(0,1),
        ];

        $headers = [
            'Authorization' => "Bearer $token"
        ];

        $this->json('POST', 'api/item/add', $payload, $headers)
             ->assertStatus(201)
             ->assertJson([
                    'data' => $payload
            ]);
    }

    public function testArticlesAreUpdatedCorrectly()
    {
        $faker = \Faker\Factory::create();

        $user = User::factory()->create();
        $token = $user->createToken('my-auth-token')->plainTextToken;

        $product = Product::factory()->create();

        $payload = [
            'name' => 'test updated!',
            'price' => '50.50',
            'sku' => $product->sku,
            'qty' => 1000,
            'unit' => 'Carton',
            'status' => 1,
        ];

        $headers = [
            'Authorization' => "Bearer $token"
        ];

        $this->json('POST', 'api/item/update', $payload, $headers)
             ->assertStatus(200)
             ->assertJson([
                    'data' => [
                        'name' => 'test updated!',
                        'price' => '50.50',
                        'sku' => $product->sku,
                        'qty' => 1000,
                        'unit' => 'Carton',
                        'status' => 1,
                    ]
            ]);
    }

    public function testArticlesAreDeletedCorrectly()
    {
        $faker = \Faker\Factory::create();

        $user = User::factory()->create();
        $token = $user->createToken('my-auth-token')->plainTextToken;

        $product = Product::factory()->create();

        $payload = [
            'sku' => $product->sku,
        ];

        $headers = [
            'Authorization' => "Bearer $token"
        ];

        $this->json('POST', 'api/item/delete', $payload, $headers)
             ->assertStatus(204);
    }

    public function testArticlesAreListedCorrectly()
    {
        $faker = \Faker\Factory::create();

        $user = User::factory()->create();
        $token = $user->createToken('my-auth-token')->plainTextToken;

        $product = Product::factory()->create();
        $product = Product::factory()->create();

        $payload = [

        ];

        $headers = [
            'Authorization' => "Bearer $token"
        ];

        $this->json('GET', 'api/items', $payload, $headers)
             ->assertStatus(200);
    }

    public function testArticlesAreListedBySkuCorrectly()
    {
        $faker = \Faker\Factory::create();

        $user = User::factory()->create();
        $token = $user->createToken('my-auth-token')->plainTextToken;

        $product = Product::factory()->create();

        $payload = [
            'sku' => $product->sku,
        ];

        $headers = [
            'Authorization' => "Bearer $token"
        ];

        $this->json('POST', 'api/item/search', $payload, $headers)
             ->assertStatus(200);
    }
}
