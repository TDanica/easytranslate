<?php

namespace App\Services\Conversion;

use App\DTO\Conversion\ConversionDTO;
use App\DTO\Conversion\ConversionRequestDTO;
use App\Exceptions\CurrencyConversionException;
use App\Interfaces\Conversion\ConversionStrategyInterface;
use App\Interfaces\Logging\LoggingServiceInterface;
use App\Services\Currency\CurrencyService;
use Illuminate\Support\Facades\DB;

class CurrencyConversionManager
{
    private ConversionStrategyInterface $conversionStrategy;

    public function __construct(
        private LoggingServiceInterface $loggingServiceInterface,
        ConversionStrategyInterface $conversionStrategy,
        private CurrencyConversionPersistenceService $currencyConversionPersistenceService,
        private CurrencyService $currencyService
    ) {
        $this->conversionStrategy = $conversionStrategy;
    }

    public function processAndSaveConversion(ConversionRequestDTO $requestDTO): ConversionDTO
    {
        DB::beginTransaction();

        try {
            $conversionDTO = $this->conversionStrategy->convert($requestDTO);

            $fromCurrencyId = $this->currencyService->getCurrencyIdByCode($conversionDTO->getFromCurrency());
            $toCurrencyId = $this->currencyService->getCurrencyIdByCode($conversionDTO->getToCurrency());

            $conversionDTO->setFromCurrencyId($fromCurrencyId);
            $conversionDTO->setToCurrencyId($toCurrencyId);

            $conversion = $this->currencyConversionPersistenceService->saveConversionResult($conversionDTO);

            DB::commit();

            return $this->mapConversionToDTO($conversion, $conversionDTO);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->loggingServiceInterface->logError('Currency conversion failed: ' . $e->getMessage());
            throw new CurrencyConversionException();
        }
    }

    private function mapConversionToDTO($conversion, ConversionDTO $conversionDTO): ConversionDTO
    {
        $conversionDTO->setId($conversion->id);
        return $conversionDTO;
    }
}
