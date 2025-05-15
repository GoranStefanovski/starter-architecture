<?php

namespace App\Applications\Common\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class CommonServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Applications\Common\Controllers';

    public function boot(): void
    {
        if ($this->app->routesAreCached()) return;

        $this->map();
    }

    public function register(): void
    {
        //
    }

    public function map(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/Common/api.php'));
    }
}