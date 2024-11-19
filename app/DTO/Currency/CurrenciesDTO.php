<?php

namespace App\DTO\Currency;

class CurrenciesDTO
{
    public array $currencies;

    public function __construct(array $currencies = [])
    {
        $this->currencies = $currencies;
    }

    public static function fromApiResponse(array $symbols): self
    {
        $dto = new self();

        foreach ($symbols as $symbol => $name) {
            $dto->currencies[] = new CurrencyDTO($symbol, $name);
        }

        return $dto;
    }

    public function toArray(): array
    {
        return array_map(function ($currencyDTO) {
            if ($currencyDTO instanceof CurrencyDTO) {
                return [
                    'symbol' => $currencyDTO->getSymbol(),
                    'name' => $currencyDTO->getName(),
                ];
            }
            return [];
        }, $this->currencies);
    }
}