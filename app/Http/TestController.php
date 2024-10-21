<?php

namespace App\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class TestController extends Controller
{
    
    public function index(): JsonResponse
    {
        return response()->json(['ok' => true]);
    }
}
