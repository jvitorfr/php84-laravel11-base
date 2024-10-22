<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Http\JsonResponse;

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
        
        return response()->json($response, $code);
    }
}

