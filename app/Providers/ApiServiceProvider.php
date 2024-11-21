<?php

namespace App\Providers;

use App\Interfaces\Conversion\ConversionStrategyInterface;
use App\Interfaces\Logging\LoggingServiceInterface;
use App\Services\Api\ApiClientService;
use App\Services\Api\ApiServiceFactory;
use App\Services\Conversion\ExternalApiConversionStrategy;
use App\Services\Currency\CurrencyApiService;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        $this->app->singleton(ApiServiceFactory::class, function ($app) {
            return new ApiServiceFactory();
        });

        $this->app->singleton(ApiClientService::class, function ($app) {
            return new ApiClientService($app->make(LoggingServiceInterface::class));
        });

        $this->app->singleton(CurrencyApiService::class, function ($app) {
            return new CurrencyApiService($app->make(ApiClientService::class));
        });

        $this->app->bind(ConversionStrategyInterface::class, ExternalApiConversionStrategy::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
