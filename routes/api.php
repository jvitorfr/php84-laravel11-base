<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Grupo de rotas da API

Route::get('/', function () {
    return view('swagger-ui');
});

Route::group(['prefix' => 'auth'], function() {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
    });
});


//Route::get('/test', [TestController::class, 'index']);
//Route::get('/test-pre-commit', [TestController::class, 'testPreCommit']);






// Esta rota de usuário não é necessária se já está dentro do grupo acima
// Você pode removê-la ou deixá-la se precisar
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
