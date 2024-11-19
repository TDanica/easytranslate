<?php

namespace App\Interfaces\Api;

interface ApiServiceInterface
{
    public function get(string $url, array $headers = [], array $params = []): array;
    public function post(string $url, array $headers = [], array $params = []): array;
}
