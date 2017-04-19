<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoadControllerTest extends TestCase
{
    /**
     * Homepage loads with status 200
     *
     * @return void
     */
    public function testHomepageShouldReturn200()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
