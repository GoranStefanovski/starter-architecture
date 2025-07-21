<?php

namespace App\Applications\Common\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CommonServiceProvider extends ServiceProvider
{
    /**
     * Set the service provider namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Applications\Common\Controllers';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->app->routesAreCached()) {
            $this->map();
            $this->app->booted(function () {
                $this->app['router']->getRoutes()->refreshNameLookups();
                $this->app['router']->getRoutes()->refreshActionLookups();
            });
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // No bindings needed for Common controllers
    }

    /**
     * Map the Common routes.
     *
     * @return void
     */
    protected function map()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace) // 👈 Point to Common\Controllers
            ->group(base_path('routes/Common/api.php'));
    }
}