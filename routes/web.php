<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('swagger-ui');
});

Route::get('/test', [TestController::class, 'index']);
Route::get('/test-pre-commit', [TestController::class, 'testPreCommit']);

