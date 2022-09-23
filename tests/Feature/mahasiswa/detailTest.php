<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class detailTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_detail()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
