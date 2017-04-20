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
        $response = $this->json('GET', '/api/search', ['term' => 'carsguide']);

        $response->assertStatus(200);
    }

    public function testMissingTermShouldReturn400()
    {
        $response = $this->json('GET', '/api/search', ['term' => null]);

        $response->assertStatus(400);
    }

    public function testApiReturns405InvalidMethod()
    {
        $response = $this->json('POST', '/api/search', ['term' => null]);

        $response->assertStatus(405);
    }

    public function testResponseJsonStructure()
    {
        $response = $this->json('GET', '/api/search', ['term' => 'carsguide']);

        $response->assertJson([
            'results' => true,
            'next_page' => true,
        ]);
    }
}
