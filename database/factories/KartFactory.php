<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KartFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'price' => fake()->randomFloat(2, 0, 999999.99),
            'available' => fake()->boolean(),
        ];
    }
}
