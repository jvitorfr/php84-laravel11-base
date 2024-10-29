<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    public function report(Throwable $e): void
    {
        Log::channel('logstash')->error('Unhandled Exception', [
            'route' => request()->route()->uri() ?? '',
            'message' => $e->getMessage(),
            'stack' => $e->getTraceAsString(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);
        parent::report($e);
    }

    public function render($request, Throwable $e): Response
    {
        return parent::render($request, $e);
    }
}
