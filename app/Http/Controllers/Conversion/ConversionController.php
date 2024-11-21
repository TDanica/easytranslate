<?php

namespace App\Http\Controllers\Conversion;

use App\DTO\Conversion\ConversionRequestDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Currency\ConversionRequest;
use App\Models\Currency\Currency;
use App\Services\Conversion\CurrencyConversionManager;
use App\Services\Logging\LoggingService;
use App\Services\Response\ResponseBuilderService;

class ConversionController extends Controller
{
    public function __construct(
        private CurrencyConversionManager $currencyConversionManager,
        private LoggingService $loggingService,
        private ResponseBuilderService $responseBuilderService
    ) {}

    public function convertForm()
    {
        $currencies = Currency::select(['id', 'code'])->get();

        return view('convert', compact('currencies'));
    }

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
            
            $this->loggingService->logError('Currency conversion failed: ' . $e->getMessage(), [
                'exception' => $e
            ]);

            return $this->responseBuilderService->error(
                'Currency conversion failed: ' . $e->getMessage()
            );
        }
    }
}
