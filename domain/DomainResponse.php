<?php

namespace Domain;

use Illuminate\Http\JsonResponse;

class DomainResponse
{
    private bool $success;
    private array $data;
    private string $message;

    public function __construct(bool $success, array $data = [], string $message = '')
    {
        $this->success = $success;
        $this->data = $data;
        $this->message = $message;
    }

    public function successResponse(): JsonResponse
    {
        return response()->json([
            'success' => $this->success,
            'data'    => $this->data,
            'message' => $this->message,
        ], 200);
    }

    public function errorResponse(int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'success' => $this->success,
            'data'    => $this->data,
            'message' => $this->message,
        ], $statusCode);
    }
}
