<?php

namespace App\Applications\VacationDay\Providers;

use App\Applications\VacationDay\Repositories\VacationDayRepository;
use App\Applications\VacationDay\Repositories\VacationDayRepositoryInterface;
use App\Applications\VacationDay\Services\VacationDayService;
use App\Applications\VacationDay\Services\VacationDayServiceInterface;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class VacationDayServiceProvider extends ServiceProvider
{
    /**
     * Set the service provider namespace
     *
     */
    protected $namespace = 'App\Applications\VacationDay';
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
        $this->app->bind(VacationDayRepositoryInterface::class, VacationDayRepository::class);
        $this->app->bind(VacationDayServiceInterface::class, VacationDayService::class);
    }

    public function map()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/VacationDay/api.php'));
    }

}
