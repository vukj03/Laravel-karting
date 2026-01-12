<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Kart;
use Illuminate\Contracts\Auth\Authenticatable;

class KartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_a_kart()
    {
        $user = User::factory()->create();

        // castujemo u Authenticatable
        $authUser = $user; /** @var Authenticatable $authUser */

        $response = $this->actingAs($authUser)->post('/karts', [
            'name' => 'Kart 1',
            'speed' => 100,
            'description' => 'Super kart',
            'price' => 50.00,
            'available' => true,
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('karts', [
            'name' => 'Kart 1',
        ]);
    }

    /** @test */
    public function user_can_view_karts()
    {
        $user = User::factory()->create();
        $kart = Kart::factory()->create();

        $authUser = $user; /** @var Authenticatable $authUser */

        $response = $this->actingAs($authUser)->get('/karts');
        $response->assertStatus(200);
        $response->assertSee($kart->name);
    }
}
