<?php

namespace App\Providers;

use App\Repositories\OrderRepository\OrderRepository;
use App\Repositories\OrderRepository\OrderRepositoryInterface;
use App\Repositories\UserRepository\UserRepository;
use App\Repositories\UserRepository\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(OrderRepositoryInterface::class, OrderRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
