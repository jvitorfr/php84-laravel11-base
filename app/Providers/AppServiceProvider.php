<?php

namespace App\Providers;

use Domain\Contracts\IEmailSender;
use Domain\Contracts\Repositories\IStoreRepository;
use Domain\Contracts\Repositories\IUserRepository;
use Domain\Mail\EmailSender;
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
        $this->app->bind(IEmailSender::class, EmailSender::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
