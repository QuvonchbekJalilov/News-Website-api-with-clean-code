<?php

namespace App\Providers;

use App\Interfaces\CategoryInterface;
use App\Interfaces\UserInterface;
use App\Repositories\Api\UserRepository;
use App\Repositories\Api\CategoryRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
