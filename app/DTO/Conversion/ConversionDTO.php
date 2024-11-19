<?php

namespace App\DTO\Conversion;

class ConversionDTO
{
    private ?int $id = null;
    private int $fromCurrencyId;
    private int $toCurrencyId;


    public function __construct(
        private string $fromCurrency,
        private string $toCurrency,
        private float $amount,
        private float $rate,
        private float $result
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromCurrency(): string
    {
        return $this->fromCurrency;
    }

    public function getToCurrency(): string
    {
        return $this->toCurrency;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function getResult(): float
    {
        return $this->result;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setFromCurrencyId(int $id): void
    {
        $this->fromCurrencyId = $id;
    }

    public function setToCurrencyId(int $id): void
    {
        $this->toCurrencyId = $id;
    }

    public function getFromCurrencyId(): int
    {
        return $this->fromCurrencyId;
    }

    public function getToCurrencyId(): int
    {
        return $this->toCurrencyId;
    }

    public function toArray(): array
    {
        return [
            'from' => $this->getFromCurrency(),
            'to' => $this->getToCurrency(),
            'amount' => $this->getAmount(),
            'rate' => $this->getRate(),
            'result' => $this->getResult(),
        ];
    }

    public static function fromApiResponse($from, $to, $amount, $rate, $result): self
    {
        return new self($from, $to, $amount, $rate, $result);
    }
}
