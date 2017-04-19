<?php

namespace Tests\Unit;

use App\Handlers\Twitter\Auth\GenerateBearer;
use App\Handlers\Twitter\Exceptions\ApiError;
use App\Handlers\Twitter\Search;
use Tests\TestCase;

class TwitterSearchTest extends TestCase
{
    private $handler;

    public function setUp()
    {
        parent::setUp();
        $this->createHandler();
    }

    public function testInvalidEndpointShouldThrowException()
    {
        $this->expectException(ApiError::class);

        config(['services.twitter.search_endpoint' => 'invalid']);

        $this->handler->process();
    }

    private function createHandler()
    {
        $this->handler = new Search(new GenerateBearer());
    }

}
