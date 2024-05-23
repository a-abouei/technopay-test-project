<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class Responder
{

    /**
     * @param string $message
     * @param array $data
     * @return JsonResponse
     */
    public static function success(string $message, array $data = []): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * @param string|null $message
     * @param string|null $stringErrorCode
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function failure(string $message = null, string $stringErrorCode = null, int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return response()->json([
            'message' => $message ?? 'An error occurred',
            'error_code' => $stringErrorCode ?? config('error_codes.internal_server_error'),
            'data' => []
        ], $statusCode);
    }

}
