<?php

namespace App\Handlers\Twitter\Exceptions;

use Exception;

class ApiError extends Exception
{
    public function __construct($message = 'Could not connect to API')
    {
        parent::__construct($message);
    }
}
