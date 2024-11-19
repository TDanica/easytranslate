<?php

namespace App\Services\Currency;

use App\Interfaces\Api\ApiServiceInterface;
use App\Services\Api\ApiClientService;
use Illuminate\Support\Facades\Config;


class CurrencyApiService implements ApiServiceInterface
{
    private string $apiKey;
    private string $baseUrl;

    public function __construct(private ApiClientService $client)
    {
        $this->apiKey = Config::get('api.currency.api_key');
        $this->baseUrl = Config::get('api.currency.base_url');
    }

    public function get(string $url, array $headers = [], array $params = []): array
    {
        $params['access_key'] = $this->apiKey;
        return $this->client->get($this->baseUrl . $url, $headers, $params);
    }

    public function post(string $url, array $headers = [], array $params = []): array
    {
        $params['access_key'] = $this->apiKey;
        return $this->client->post($this->baseUrl . $url, $headers, $params);
    }
}
