<?php

namespace App\Interfaces\Cache;

interface CachingServiceInterface
{
    public function cache(string $key, callable $callback, int $ttl = 60);
}