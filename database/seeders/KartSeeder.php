<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kart;

class KartSeeder extends Seeder
{
    public function run()
    {
        Kart::create([
            'name' => 'Kart 1',
            'speed' => 100,
            'description' => 'Brzi kart za početnike',
            'price' => 50.00,
            'available' => true,
        ]);

        Kart::create([
            'name' => 'Kart 2',
            'speed' => 120,
            'description' => 'Napredni kart za trkače',
            'price' => 70.00,
            'available' => true,
        ]);

        // možeš dodati još test kartova po želji
    }
}
