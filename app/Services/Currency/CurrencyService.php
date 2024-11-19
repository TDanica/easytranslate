<?php

namespace App\Services\Currency;

use App\DTO\Currency\CurrenciesDTO;
use App\Exceptions\CacheException;
use App\Exceptions\CurrencyFetchException;
use App\Exceptions\CurrencyNotFoundException;
use App\Models\Currency\Currency;
use App\Repositories\Currency\CurrencyRepository;
use App\Services\Api\ApiServiceFactory;
use App\Services\Cache\CachingService;
use App\Services\Logging\LoggingService;
use Exception;

class CurrencyService
{
    private CurrencyApiService $currencyApiService;

    public function __construct(
        private ApiServiceFactory $apiServiceFactory,
        private CurrencyRepository $currencyRepository,
        private CachingService $cachingService,
        private LoggingService $loggingService
    ) {
        $this->currencyApiService = $this->apiServiceFactory->create('currency');
    }

    public function getCurrencies(): CurrenciesDTO
    {
        try {
            $cacheKey = 'currencies_' . md5('version_1' . config('currency.api_version'));
            $ttl = config('currency.cache_ttl', 3600);

            $currencies = $this->cachingService->cache($cacheKey, fn() => $this->currencyApiService->get('/symbols'), $ttl);

            return CurrenciesDTO::fromApiResponse($currencies['symbols']);
        } catch (CacheException | CurrencyFetchException $e) {
            $this->loggingService->logError('Error when fetching currencies: ' . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            $this->loggingService->logError('Unexpected error: ' . $e->getMessage());
            throw new Exception('An unexpected error occurred while fetching currencies.');
        }
    }

    public function getCurrenciesByIds(int $fromCurrencyId, int $toCurrencyId): array
    {
        $fromCurrency = $this->currencyRepository->findSymbolById($fromCurrencyId);
        $toCurrency = $this->currencyRepository->findSymbolById($toCurrencyId);

        if (!$fromCurrency || !$toCurrency) {
            throw new CurrencyNotFoundException('One or both currencies could not be found.');
        }

        return [$fromCurrency, $toCurrency];
    }

    public function getCurrencyIdByCode(string $currencyCode): int
    {
        $currency = Currency::where('code', $currencyCode)->first();

        if (!$currency) {
            throw new Exception('Currency not found for code: ' . $currencyCode);
        }

        return $currency->id;
    }
}
