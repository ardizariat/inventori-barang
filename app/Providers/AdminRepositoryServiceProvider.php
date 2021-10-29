<?php

namespace App\Providers;

use App\Repositories\GudangRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\GudangRepositoryInterface;

class AdminRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            GudangRepositoryInterface::class,
            GudangRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
