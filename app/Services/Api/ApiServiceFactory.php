<?php

namespace App\Services\Api;

use App\Interfaces\Api\ApiServiceInterface;
use App\Services\Currency\CurrencyApiService;
use InvalidArgumentException;

class ApiServiceFactory
{
    protected array $apiServices;

    public function __construct()
    {
        $this->apiServices = [
            'currency' => CurrencyApiService::class,
        ];
    }

    public function create(string $apiName): ApiServiceInterface
    {
        if (!isset($this->apiServices[$apiName])) {
            throw new InvalidArgumentException("API service not found for: $apiName");
        }

        return app($this->apiServices[$apiName]);
    }
}