<?php

namespace App\Repositories\Currency;

use App\Models\Currency\Currency;

class CurrencyRepository
{
    public function getCurrencies(): array
    {
        $currencies = Currency::get(['code', 'name'])->toArray();

        return $currencies;
    }

    public function saveCurrencies(array $currencies): void
    {
        foreach ($currencies as $currency) {
            Currency::updateOrCreate(
                ['code' => $currency->getSymbol()],
                ['name' => $currency->getName()]
            );
        }
    }

    public function findSymbolById(int $id): ?string
    {
        return Currency::where('id', $id)->value('symbol');
    }
}
