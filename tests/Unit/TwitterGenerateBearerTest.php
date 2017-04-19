<?php

namespace Tests\Unit;

use App\Handlers\Twitter\Auth\GenerateBearer;
use App\Handlers\Twitter\Exceptions\ApiError;
use App\Handlers\Twitter\Exceptions\InvalidConfig;
use Cache;
use ReflectionClass;
use Tests\TestCase;

class TwitterGenerateBearerTest extends TestCase
{
    private $handler;

    public function setUp()
    {
        parent::setUp();
        $this->createHandler();
    }

    private function createHandler()
    {
        $this->handler = new GenerateBearer();
    }

    public function testCanGenerateBearerToken()
    {
        $bearerToken = $this->handler->generate()->getBearer();

        $this->assertTrue(is_string($bearerToken));
    }

    public function testCacheIsSet()
    {
        $this->handler->generate()->getBearer();

        $this->assertTrue(Cache::has('twitter_bearer'));
    }

    public function testCacheIsCheckedAndReturned()
    {
        Cache::shouldReceive('has')->once()->andReturn(true);
        Cache::shouldReceive('get')->andReturn(true);

        $reflector = new ReflectionClass(GenerateBearer::class);
        $method = $reflector->getMethod('canReturnCachedBearer');
        $method->setAccessible(true);

        $result = $method->invokeArgs($this->handler, []);

        $this->assertTrue($result);
    }

    public function testInvalidConfigShouldThrowException()
    {
        $this->expectException(InvalidConfig::class);

        //invalid config
        config(['services.twitter.key' => null]);

        //create handler with invalid config
        $this->createHandler();

        $this->handler->generate()->getBearer();
    }

    public function testCannotConnectToApiShouldThrowException()
    {
        $this->expectException(ApiError::class);

        config(['services.twitter.auth_endpoint' => 'https://invalidendpoint']);

        $this->handler->generate()->getBearer();
    }

}
