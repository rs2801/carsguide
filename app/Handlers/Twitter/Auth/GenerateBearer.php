<?php

namespace App\Handlers\Twitter\Auth;

use App\Handlers\Twitter\Exceptions\ApiError;
use App\Handlers\Twitter\Exceptions\BearerError;
use App\Handlers\Twitter\Exceptions\InvalidConfig;
use Cache;
use Exception;
use Requests;

class GenerateBearer
{
    const CACHE_KEY = "twitter_bearer";

    private $key;
    private $secret;
    private $response;
    private $regenerate = false;

    public function __construct()
    {
        $this->key = config('services.twitter.key');
        $this->secret = config('services.twitter.secret');
    }

    public function setRegenerate($regenerate)
    {
        $this->regenerate = $regenerate;
        return $this;
    }

    public function getBearer()
    {
        return $this->bearer;
    }

    public function generate()
    {
        /*
        - if cache has bearer already set and not generating, return
        - Check config is set
        - call the twitter oAuth endpoint
        - extract the bearer token
        - set cache
         */

        if ($this->canReturnCachedBearer()) {
            return $this;
        }

        $this->checkConfig();
        $this->callTwitterOAuth();
        $this->extractBearerToken();
        $this->setCache();

        return $this;
    }

    private function canReturnCachedBearer()
    {
        if (Cache::has(self::CACHE_KEY) && !$this->regenerate) {
            $this->bearer = Cache::get(self::CACHE_KEY);
            return true;
        }

        return false;
    }

    private function checkConfig()
    {
        if (!isset($this->key) || !isset($this->secret)) {
            throw new InvalidConfig();
        }
    }

    private function callTwitterOAuth()
    {
        try {
            $response = Requests::post(config('services.twitter.auth_endpoint'), $this->bearerHeaders(), ['grant_type' => 'client_credentials']);
        } catch (Exception $e) {
            throw new ApiError();
        }

        $this->response = json_decode($response->body);
    }

    private function bearerHeaders()
    {
        return [
            'Authorization' => 'Basic ' . base64_encode($this->key . ':' . $this->secret),
            'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8',
        ];
    }

    private function extractBearerToken()
    {
        if (isset($this->response->token_type) && $this->response->token_type == 'bearer') {
            $this->bearer = $this->response->access_token;
            return;
        }

        throw new BearerError();
    }

    private function setCache()
    {
        Cache::forever(self::CACHE_KEY, $this->bearer);
    }

}
