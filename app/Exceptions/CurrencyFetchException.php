<?php

namespace App\Exceptions;

use Exception;

class CurrencyFetchException extends Exception
{
    protected $message = 'Failed to fetch currency data.';
}
