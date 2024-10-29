<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @param string[] $result
     * @param string $message
     * @return JsonResponse
     */
    public function sendResponse(array $result, string $message): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ], 200);
    }

    /**
     * return error response.
     *
     * @param string|string[] $error
     * @param string[]|MessageBag $errorMessages
     * @param int $code
     * @return JsonResponse
     */
    public function sendError(string|array $error, array|MessageBag $errorMessages = [], int $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        
        $this->log($response, 'error',  $error);

        return response()->json($response, $code);
    }
    
    public function log(array $info, string $status, string $message = null): void
    {
        Log::channel('logstash')->info(request()->route()->uri(), [
            'info' => $info,
            'timestamp' => now()->toIso8601String(),
            'status' => $status,
            'message' => is_null($message) ? "success": $message,
        ]);
    }
    
}
