<?php

namespace App\Exceptions;

use Exception;

class CacheException extends Exception
{
    protected $message = 'Cache operation failed.';
}
