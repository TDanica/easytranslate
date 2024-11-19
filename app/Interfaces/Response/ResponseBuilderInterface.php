<?php

namespace App\Interfaces\Response;

interface ResponseBuilderInterface
{
    public function success($data = null, string $message = 'Request was successful', int $statusCode = 200);
    public function error(string $message = 'An error occurred', int $statusCode = 500, $data = null);
}