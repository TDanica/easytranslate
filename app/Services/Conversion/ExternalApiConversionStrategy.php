<?php

namespace App\Services\Conversion;
use App\DTO\Conversion\ConversionDTO;
use App\DTO\Conversion\ConversionRequestDTO;
use App\Interfaces\Conversion\ConversionStrategyInterface;
use App\Services\Currency\CurrencyApiService;
use App\Services\Currency\CurrencyService;
use Exception;

class ExternalApiConversionStrategy implements ConversionStrategyInterface
{

    public function __construct(
        private CurrencyApiService $currencyApiService,
        private CurrencyService $currencyService
    ) {}

    public function convert(ConversionRequestDTO $conversionRequestDTO): ConversionDTO
    {
        $url = '/convert';

        [$fromCurrencyCode, $toCurrencyCode] = $this->currencyService->getCurrenciesByIds(
            $conversionRequestDTO->getFromCurrency(),
            $conversionRequestDTO->getToCurrency()
        );

        $params = [
            'from' => $fromCurrencyCode,
            'to' => $toCurrencyCode,
            'amount' => $conversionRequestDTO->getAmount(),
        ];

        try {
            $response = $this->currencyApiService->get($url, [], $params);

            if (empty($response['success']) || !$response['success']) {
                throw new Exception('Error from Conversion API: ' . ($response['error']['info'] ?? 'Unknown error'));
            }

            return ConversionDTO::fromApiResponse(
                $response['query']['from'],
                $response['query']['to'],
                $response['query']['amount'],
                $response['info']['rate'],
                $response['result']
            );
        } catch (Exception $e) {
            throw new Exception('Failed to convert currency: ' . $e->getMessage());
        }
    }
}
