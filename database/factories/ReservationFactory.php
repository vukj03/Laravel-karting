<?php

namespace Database\Factories;

use App\Models\Kart;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'kart_id' => Kart::factory(),
            'date' => fake()->date(),
            'time' => fake()->time(),
            'status' => fake()->word(),
        ];
    }
}
