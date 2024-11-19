<?php

namespace App\Services\Cache;

use App\Interfaces\Cache\CachingServiceInterface;
use Illuminate\Support\Facades\Cache;

class CachingService implements CachingServiceInterface
{
    public function cache(string $key, callable $callback, int $ttl = 60)
    {
        return Cache::remember($key, $ttl, $callback);
    }
}