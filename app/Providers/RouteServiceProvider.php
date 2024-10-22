<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * O caminho para o "namespace" da aplicação.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Defina as rotas da aplicação.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Defina as rotas da API.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api') // Prefixo para suas rotas API
        ->middleware('api') // Middleware que você quer aplicar
        ->namespace($this->namespace) // Namespace dos controladores
        ->group(base_path('routes/api.php')); // O arquivo de rotas
    }

    /**
     * Defina as rotas da web.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web') // Middleware para suas rotas web
        ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }
}
