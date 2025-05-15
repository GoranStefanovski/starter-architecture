<?php

namespace App\Applications\Venue\Providers;

use App\Applications\Venue\Repositories\VenueRepository;
use App\Applications\Venue\Repositories\VenueRepositoryInterface;
use App\Applications\Venue\Services\VenueService;
use App\Applications\Venue\Services\VenueServiceInterface;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class VenueServiceProvider extends ServiceProvider
{
    /**
     * Set the service provider namespace
     *
     */
    protected $namespace = 'App\Applications\Venue';
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
        $this->app->bind(VenueRepositoryInterface::class, VenueRepository::class);
        $this->app->bind(VenueServiceInterface::class, VenueService::class);
    }

    public function map()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/Venue/api.php'));
    }

}
