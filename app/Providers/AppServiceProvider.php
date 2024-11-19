<?php

namespace App\Providers;

use App\Interfaces\Cache\CachingServiceInterface;
use App\Interfaces\Logging\LoggingServiceInterface;
use App\Interfaces\Response\ResponseBuilderInterface;
use App\Services\Cache\CachingService;
use App\Services\Response\ResponseBuilderService;
use Illuminate\Support\ServiceProvider;
use PHPUnit\TextUI\XmlConfiguration\Logging\Logging;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CachingServiceInterface::class, CachingService::class);

        $this->app->singleton(ResponseBuilderInterface::class, ResponseBuilderService::class);

        $this->app->singleton(LoggingServiceInterface::class, Logging::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
