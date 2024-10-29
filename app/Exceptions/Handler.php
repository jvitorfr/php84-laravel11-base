<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    
    public function report(Throwable $exception)
    {
        Log::channel('logstash')->error('Unhandled Exception', [
            'route' => request()->route()->uri() ?? '',
            'message' => $exception->getMessage(),
            'stack' => $exception->getTraceAsString(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);
        
        
        parent::report($exception);
    }
    
    public function render($request, Throwable $exception): Response
    {
        return response()->json([
            'error' => 'Ocorreu um erro inesperado.'
        ], 500);
    
        return parent::render($request, $exception);
    }
}
