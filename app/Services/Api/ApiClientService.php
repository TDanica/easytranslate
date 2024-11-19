<?php

namespace App\Services\Api;

use App\Interfaces\Api\ApiServiceInterface;
use App\Services\Logging\LoggingService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class ApiClientService implements ApiServiceInterface
{
    private Client $client;

    public function __construct(private LoggingService $loggingService)
    {
        $this->client = new Client();
    }

    public function get(string $url, array $headers = [], array $params = []): array
    {
        try {
            $response = $this->client->get($url, [
                'headers' => $headers,
                'query' => $params
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->loggingService->logError('API request failed: ' . $e->getMessage(), [
                'url' => $url,
                'params' => $params,
                'exception' => $e->getTraceAsString()
            ]);
            throw new \Exception('API request failed');
        }
    }

    public function post(string $url, array $headers = [], array $params = []): array
    {
        try {
            $response = $this->client->post($url, [
                'headers' => $headers,
                'json' => $params
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            Log::error('API request failed: ' . $e->getMessage(), [
                'url' => $url,
                'params' => $params,
                'exception' => $e->getTraceAsString()
            ]);
            throw new \Exception('API request failed');
        }
    }
}
