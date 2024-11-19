<?php

namespace App\Exceptions;

use Exception;

class CurrencyConversionException extends Exception
{
    protected $message = 'Currency conversion failed';
}
