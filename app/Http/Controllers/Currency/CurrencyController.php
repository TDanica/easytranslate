<?php

namespace App\Http\Controllers\Currency;

use App\Exceptions\CacheException;
use App\Exceptions\CurrencyFetchException;
use App\Http\Controllers\Controller;
use App\Interfaces\Logging\LoggingServiceInterface;
use App\Services\Currency\CurrencyService;
use App\Services\Response\ResponseBuilderService;
use Exception;

class CurrencyController extends Controller
{
    public function __construct(
        private CurrencyService $currencyService,
        private LoggingServiceInterface $loggingServiceInterface,
        private ResponseBuilderService $responseBuilderService,
    ) {}

    public function index()
    {
        try {
            $currenciesDTO = $this->currencyService->getCurrencies();

            return $this->responseBuilderService->success(
                $currenciesDTO->toArray(),
                'Currencies fetched successfully.'
            );

        } catch (CurrencyFetchException $e) {
            $this->loggingServiceInterface->logError('Currency fetch failed: ' . $e->getMessage());
            return $this->responseBuilderService->error('Something went wrong. Please try again later.', 500);
        } catch (CacheException $e) {
            $this->loggingServiceInterface->logError('Cache error: ' . $e->getMessage());
            return $this->responseBuilderService->error('There was an issue processing your request. Please try again later.', 500);
        } catch (Exception $e) {
            $this->loggingServiceInterface->logError('Unexpected error: ' . $e->getMessage());
            return $this->responseBuilderService->error('An unexpected error occurred. Please try again later.', 500);
        }
    }
}
