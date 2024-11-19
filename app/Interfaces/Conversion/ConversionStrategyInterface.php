<?php

namespace App\Interfaces\Conversion;

use App\DTO\Conversion\ConversionDTO;
use App\DTO\Conversion\ConversionRequestDTO;

interface ConversionStrategyInterface
{
    public function convert(ConversionRequestDTO $conversionRequestDTO): ConversionDTO;
}