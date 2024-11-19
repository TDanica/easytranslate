<?php

namespace App\DTO\Currency;

class CurrencyDTO
{


    public function __construct(
        private string $symbol,
        private string $name
    ) {}

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function fromApiResponse(string $symbol, string $name): self
    {
        return new self($symbol, $name);
    }
}
