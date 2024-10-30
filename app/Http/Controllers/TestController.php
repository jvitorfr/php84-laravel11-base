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
        $checkInData = serialize([
            'user_id' => 1,
            'location' => 'location',
            'timestamp' => now(),
        ]);
        
       // CheckInJob::dispatch($checkInData)->onQueue('checkins')->delay(now()->addMinutes(1));
       CheckInJob::dispatch()->onQueue('checkins');

        return response()->json(['message' => 'test job checkin']);
    }
}
