<?php

namespace App\Interfaces\Logging;

interface LoggingServiceInterface
{
    public function logInfo(string $message, array $context = []): void;
    public function logError(string $message, array $context = []): void;
    public function logWarning(string $message, array $context = []): void;
}