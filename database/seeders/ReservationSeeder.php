<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reservation::create([
            'user_id' => 1, // Test User
            'kart_id' => 1, // Kart 1
            'reservation_date' => Carbon::now()->addDay(),
        ]);

        Reservation::create([
            'user_id' => 2, // Admin User
            'kart_id' => 2, // Kart 2
            'reservation_date' => Carbon::now()->addDays(2),
        ]);
    }
}
