<?php

namespace Database\Factories;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(20),
            'sku' => Str::random(10),
            'price' => $this->faker->randomNumber(),
            'qty' => $this->faker->numberBetween(1000,9000),
            'unit' => 'Carton',
            'status' => $this->faker->numberBetween(0,1),
        ];
    }
}
