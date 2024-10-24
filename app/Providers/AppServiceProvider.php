<?php

namespace App\Providers;

use Domain\Contracts\Repositories\IStoreRepository;
use Domain\Contracts\Repositories\IUserRepository;
use Domain\Store\Repositories\StoreRepository;
use Domain\User\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IStoreRepository::class, StoreRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
