<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_the_home_page_returns_a_successful_response(): void
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
