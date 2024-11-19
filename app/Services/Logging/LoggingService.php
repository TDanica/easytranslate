<?php

namespace App\Services\Logging;

use App\Interfaces\Logging\LoggingServiceInterface;
use Illuminate\Support\Facades\Log;

class LoggingService implements LoggingServiceInterface
{
    public function logInfo(string $message, array $context = []): void
    {
        Log::info($message, $context);
    }

    public function logError(string $message, array $context = []): void
    {
        Log::error($message, $context);
    }

    public function logWarning(string $message, array $context = []): void
    {
        Log::warning($message, $context);
    }
}