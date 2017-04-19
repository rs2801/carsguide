<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiSearchControllerTest extends TestCase
{
    /**
     * API loads with status 200
     *
     * @return void
     */
    public function testResponseValid()
    {
        $response = $this->get('/api/search?term=carsguide');

        $response->assertStatus(200);
    }

    public function testMissingTermShouldReturn400()
    {
        $response = $this->get('/api/search');

        $response->assertStatus(400);
    }
}
