<?php

namespace App\Handlers\Twitter\Exceptions;

use Exception;

class BearerError extends Exception
{
    public function __construct($message = 'Could not get Bearer Details')
    {
        parent::__construct($message);
    }
}
