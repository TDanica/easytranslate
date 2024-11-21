<?php

namespace App\Http\Controllers\Conversion;

use App\DTO\Conversion\ConversionRequestDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Currency\ConversionRequest;
use App\Interfaces\Logging\LoggingServiceInterface;
use App\Services\Conversion\CurrencyConversionManager;
use App\Services\Response\ResponseBuilderService;

class ConversionController extends Controller
{
    public function __construct(
        private CurrencyConversionManager $currencyConversionManager,
        private LoggingServiceInterface $loggingServiceInterface,
        private ResponseBuilderService $responseBuilderService
    ) {}

    public function convert(ConversionRequest $request)
    {
        try {
            $data = $request->validated();

            $requestDTO = new ConversionRequestDTO(
                $data['from'],
                $data['to'],
                $data['amount']
            );

            $conversionDTO = $this->currencyConversionManager->processAndSaveConversion($requestDTO);

            return $this->responseBuilderService->success(
                $conversionDTO->toArray(),
                'Currency conversion successful'
            );
        } catch (\Exception $e) {
            $this->loggingServiceInterface->logError('Currency conversion failed: ' . $e->getMessage(), [
                'exception' => $e
            ]);

            return $this->responseBuilderService->error(
                'Currency conversion failed: ' . $e->getMessage()
            );
        }
    }
}
