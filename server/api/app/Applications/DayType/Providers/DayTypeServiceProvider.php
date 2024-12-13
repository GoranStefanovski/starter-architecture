<?php

namespace App\Applications\DayType\Providers;

use App\Applications\DayType\Repositories\DayTypeRepository;
use App\Applications\DayType\Repositories\DayTypeRepositoryInterface;
use App\Applications\DayType\Services\DayTypeService;
use App\Applications\DayType\Services\DayTypeServiceInterface;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class DayTypeServiceProvider extends ServiceProvider
{
    /**
     * Set the service provider namespace
     *
     */
    protected $namespace = 'App\Applications\DayType';
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->routesAreCached()) {
         //  This is already done in the main RouteServiceProvider so not needed here
        } else {

            $this->app->call([$this, 'map']);

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
        $this->app->bind(DayTypeRepositoryInterface::class, DayTypeRepository::class);
        $this->app->bind(DayTypeServiceInterface::class, DayTypeService::class);
    }

    public function map()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/Common/api.php'));
    }

}
