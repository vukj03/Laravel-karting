<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * Test da welcome stranica radi.
     */
    public function test_welcome_page_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Welcome');
    }

    /**
     * Test da login stranica radi.
     */
    public function test_login_page_loads_successfully(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Email');
        $response->assertSee('Password');
    }

    /**
     * Test da register stranica radi.
     */
    public function test_register_page_loads_successfully(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Name');
        $response->assertSee('Email');
    }
}