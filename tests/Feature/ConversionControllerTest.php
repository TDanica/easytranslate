<?php

namespace Tests\Feature;

namespace Tests\Feature;

use App\Models\Currency\Currency;
use App\Services\Conversion\CurrencyConversionManager;
use App\Services\Conversion\CurrencyConversionPersistenceService;
use App\Services\Conversion\ExternalApiConversionStrategy;
use App\Services\Currency\CurrencyService;
use App\Services\Logging\LoggingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class ConversionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_convert_currency_and_return_response()
    {
        Currency::factory()->state(['code' => 'USD'])->create();
        Currency::factory()->state(['code' => 'EUR'])->create();

        /** @var \App\Services\Currency\CurrencyApiService|Mockery\MockInterface $currencyApiServiceMock */
        $currencyApiServiceMock = Mockery::mock('App\Services\Currency\CurrencyApiService');

        /** @var \App\Services\Currency\CurrencyService|Mockery\MockInterface $currencyServiceMock */
        $currencyServiceMock = Mockery::mock(CurrencyService::class);

        /** @var \App\Services\Conversion\CurrencyConversionPersistenceService|Mockery\MockInterface $persistenceServiceMock */
        $persistenceServiceMock = Mockery::mock(CurrencyConversionPersistenceService::class);

        /** @var \App\Services\Logging\LoggingService|Mockery\MockInterface $loggingServiceMock */
        $loggingServiceMock = Mockery::mock(LoggingService::class);

        $currencyServiceMock->shouldReceive('getCurrenciesByIds')
            ->once()
            ->with(1, 2)
            ->andReturn(['USD', 'EUR']);

        $currencyServiceMock->shouldReceive('getCurrencyIdByCode')
            ->andReturnUsing(fn($code) => $code === 'USD' ? 1 : 2);

        $currencyApiServiceMock->shouldReceive('get')
            ->once()
            ->andReturn([
                'success' => true,
                'query' => ['from' => 'USD', 'to' => 'EUR', 'amount' => 100.00],
                'info' => ['rate' => 0.85],
                'result' => 85.00,
            ]);

            $conversion = new \App\Models\Currency\Conversion([
                'id' => 1,
                'from_currency_id' => 1,
                'to_currency_id' => 2,
                'amount' => 100,
                'rate' => 1.2,
                'result' => 120,
            ]);
            
            $persistenceServiceMock->shouldReceive('saveConversionResult')
                ->once()
                ->andReturn($conversion);

        $conversionStrategy = new ExternalApiConversionStrategy(
            $currencyApiServiceMock,
            $currencyServiceMock
        );

        $manager = new CurrencyConversionManager(
            $loggingServiceMock,
            $conversionStrategy,
            $persistenceServiceMock,
            $currencyServiceMock
        );

        $this->app->instance(CurrencyConversionManager::class, $manager);

        $data = [
            'from' => 1,
            'to' => 2,
            'amount' => 100.00,
        ];

        $response = $this->post('/convert', $data);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Currency conversion successful',
            'data' => [
                'from' => 'USD',
                'to' => 'EUR',
                'amount' => 100.00,
                'rate' => 0.85,
                'result' => 85.00,
            ],
        ]);
    }
}
