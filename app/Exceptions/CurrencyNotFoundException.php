<?php

namespace App\Exceptions;

use Exception;

class CurrencyNotFoundException extends Exception
{
    protected $message = 'Currency not found for the provided ID';
}
