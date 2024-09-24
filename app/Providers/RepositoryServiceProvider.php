<?php

namespace App\Providers;

use App\Repositories\User\Contract\UserAuthInterface;
use App\Repositories\User\UserAuthRepository;
use App\Repositories\Post\Contract\PostInterface;
use App\Repositories\Post\PostRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            PostInterface::class,
            PostRepository::class            
        );

        $this->app->bind(
            UserAuthInterface::class,
            UserAuthRepository::class            
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
