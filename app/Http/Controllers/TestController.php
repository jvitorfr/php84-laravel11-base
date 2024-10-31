<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Swoole\Coroutine as Co;

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
    
    public function testCheckinJob(): JsonResponse
    {
        $this->testCoroutines();
        return response()->json(['message' => 'Job is being processed asynchronously.']);
        
    }
    
    function testCoroutines()
    {
        go(function () {
            Co::sleep(5);
            Log::channel('logstash')->info('go 1.', [
                'job_id' => 1,
                'status' => 'completed',
                'timestamp' => now()->toIso8601String(),
            ]);
        });
        
        go(function () {
            Co::sleep(5);
            Log::channel('logstash')->info('go 2.', [
                'job_id' => 2,
                'status' => 'completed',
                'timestamp' => now()->toIso8601String(),
            ]);
        });
    
    
        go(function () {
            Co::sleep(2);
            Log::channel('logstash')->info('go 3 sempre antes.', [
                'job_id' => 3,
                'status' => 'completed',
                'timestamp' => now()->toIso8601String(),
            ]);
        });
    }
    
}
