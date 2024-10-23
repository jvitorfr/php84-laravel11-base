<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class TestController extends BaseController
{
    public function index(): JsonResponse
    {
        $data = [
            'message' => 'Dados retornados com sucesso'
        ];

        return response()->json($data);
    }

    public function testPreCommit(): JsonResponse
    {
        $data = [
            'message' => 'Dados retornados com sucesso'
        ];

        return response()->json($data);
    }
}
