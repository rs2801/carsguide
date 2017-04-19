<?php

namespace App\Handlers\Twitter\Exceptions;

use Exception;

class InvalidConfig extends Exception
{
    public function __construct($message = 'Twitter API configuration error')
    {
        parent::__construct($message);
    }
}
