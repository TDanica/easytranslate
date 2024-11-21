<?php

namespace App\Services\Conversion;

use App\DTO\Conversion\ConversionDTO;
use App\Models\Currency\Conversion;
use App\Repositories\Currency\ConversionRepository;

class CurrencyConversionPersistenceService
{
    private ConversionRepository $conversionRepository;

    public function __construct(ConversionRepository $conversionRepository)
    {
        $this->conversionRepository = $conversionRepository;
    }

    public function saveConversionResult(ConversionDTO $conversionDTO): Conversion
    {
        return $this->conversionRepository->saveConversionResult($conversionDTO);
    }
}
