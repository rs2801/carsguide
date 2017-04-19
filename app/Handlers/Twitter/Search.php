<?php

namespace App\Handlers\Twitter;

use App\Handlers\Twitter\Auth\GenerateBearer;
use App\Handlers\Twitter\Exceptions\ApiError;
use Exception;
use Requests;

class Search extends BaseHandler
{
    const PAGINATE = 15;

    protected $term;
    protected $result_type;
    protected $next_page;

    public function __construct(GenerateBearer $GenerateBearer)
    {
        parent::__construct($GenerateBearer);
    }

    public function setResultType($result_type)
    {
        $this->result_type = $result_type;
        return $this;
    }

    public function setTerm($term)
    {
        $this->term = $term;
        return $this;
    }

    public function setNextPage($next_page)
    {
        $this->next_page = $next_page;
        return $this;
    }

    public function output()
    {
        //take 15 results
        $results = collect($this->response->statuses);
        $count = $results->count();
        $results = $results->take(self::PAGINATE);

        if (count($results) > 0 && $count > self::PAGINATE) {
            $next_page = bcsub($results->last()->id_str, '1');
        } else {
            $next_page = null;
        }

        return (object) [
            'results' => $results,
            'next_page' => $next_page,
        ];
    }

    protected function callApi()
    {
        try {
            $response = Requests::get($this->buildUrl(config('services.twitter.search_endpoint'), $this->createParams()), $this->headers());
        } catch (Exception $e) {
            throw new ApiError();
        }

        $this->response = json_decode($response->body);
        $this->responseCode = $response->status_code;
    }

    protected function responseValid()
    {
        //if response is 401, bearer invalid, regenerate once and search
        if ($this->responseCode == 401 && !$this->regenerate) {
            $this->regenerateBearer();
            $this->search();
        }

        if (isset($this->response->errors) || $this->responseCode != 200) {
            throw new ApiError();
        }
    }

    protected function createParams()
    {
        //take extra 5 from twitter API due to it being unreliable with count param
        $params = [
            'q' => $this->term,
            'src' => 'typd',
            'result_type' => $this->result_type,
            'count' => self::PAGINATE + 5,
        ];

        if ($this->next_page) {
            $params['max_id'] = $this->next_page;
        }

        return $params;
    }

}
