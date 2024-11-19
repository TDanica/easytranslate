<?php

namespace App\DTO\Conversion;

class ConversionRequestDTO
{
    public function __construct(
        private int $fromCurrency,
        private int $toCurrency,
        private float $amount
    ) {}

    // Getters
    public function getFromCurrency(): int
    {
        return $this->fromCurrency;
    }

    public function getToCurrency(): int
    {
        return $this->toCurrency;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function toArray(): array
    {
        return [
            'from' => $this->getFromCurrency(),
            'to' => $this->getToCurrency(),
            'amount' => $this->getAmount(),
        ];
    }
}
