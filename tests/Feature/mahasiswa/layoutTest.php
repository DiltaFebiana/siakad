<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class layoutTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_layout()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
