<?php

namespace App\Services\Response;

use App\Interfaces\Response\ResponseBuilderInterface;
use Illuminate\Http\JsonResponse;

class ResponseBuilderService implements ResponseBuilderInterface
{
    public function success($data = null, string $message = 'Request was successful', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    public function error(string $message = 'An error occurred', int $statusCode = 500, $data = null): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }
}
