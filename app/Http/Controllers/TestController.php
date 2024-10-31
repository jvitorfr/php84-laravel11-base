<?php

namespace App\Http\Controllers;

use App\Jobs\CheckInJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

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
        $checkInData = [
            'user_id' => 123,
            'location' => 'Exemplo de Local',
            'timestamp' => now()->toIso8601String(),
        ];
        
//        CheckInJob::dispatch($checkInData)->onQueue('checkins')->delay(now()->addMinutes(1));
       CheckInJob::dispatch($checkInData)->onQueue('checkins');
       //dispatch(new CheckInJob($checkInData))->onQueue('checkins');
      // CheckInJob::dispatch($checkInData)->delay(now()->addMinutes(1));

        return response()->json(['message' => 'test job checkin']);
    }
}
