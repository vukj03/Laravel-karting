<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Kart;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_reservation()
    {
        /** @var \App\Models\User&\Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();

        $kart = Kart::factory()->create();

        $response = $this->actingAs($user)->post('/reservations', [
            'user_id' => $user->id,
            'kart_id' => $kart->id,
            'reservation_date' => now()->addDay()->format('Y-m-d H:i:s'),
        ]);

        $response->assertStatus(302); // redirekt nakon kreiranja
        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'kart_id' => $kart->id,
        ]);
    }

    /** @test */
    public function a_user_can_view_their_reservations()
    {
        /** @var \App\Models\User&\Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();

        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get('/reservations');

        $response->assertStatus(200);
        $response->assertSee($reservation->id);
    }
}
