<?php

namespace App\Handlers\Twitter;

class BaseHandler
{
    private $key;
    private $secret;
    public $bearer;
    public $regenerate = false;

    public function __construct($bearer)
    {
        $this->GenerateBearer = $bearer;

        $this->bearer = $this->GenerateBearer
            ->generate()
            ->getBearer();
    }

    public function process()
    {
        $this->callApi();
        $this->responseValid();
        return $this;
    }

    protected function regenerateBearer()
    {
        $this->regenerate = true;

        $this->bearer = $this->GenerateBearer
            ->setRegenerate(true)
            ->generate()
            ->getBearer();
    }

    protected function headers()
    {
        return [
            'Authorization' => 'Bearer ' . $this->bearer,
        ];
    }

    protected function buildUrl($urlPoint, $params = [])
    {
        return $urlPoint . '?' . http_build_query($params);
    }

}
