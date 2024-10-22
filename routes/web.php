<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('swagger-ui');
});

Route::get('/test', [TestController::class, 'index']);
Route::get('/test-pre-commit', [TestController::class, 'testPreCommit']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::middleware('auth:sanctum')->group( function () {
    Route::get('/test-login', TestController::class);
});
