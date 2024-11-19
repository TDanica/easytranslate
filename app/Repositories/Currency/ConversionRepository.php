<?php

namespace App\Repositories\Currency;

use App\DTO\Conversion\ConversionDTO;
use App\Models\Currency\Conversion;

class ConversionRepository
{
    public function saveConversionResult(ConversionDTO $conversionDTO): Conversion
    {
        $conversion = Conversion::create([
            'from_currency_id' => $conversionDTO->getFromCurrencyId(),
            'to_currency_id' => $conversionDTO->getToCurrencyId(),
            'amount' => $conversionDTO->getAmount(),
            'rate' => $conversionDTO->getRate(),
            'result' => $conversionDTO->getResult(),
        ]);

        return $conversion;
    }
}
