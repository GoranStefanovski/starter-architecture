<?php

namespace App\Applications\Store\Providers;

use App\Applications\Store\Repositories\StoreRepository;
use App\Applications\Store\Repositories\StoreRepositoryInterface;
use App\Applications\Store\Services\StoreService;
use App\Applications\Store\Services\StoreServiceInterface;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class StoreServiceProvider extends ServiceProvider
{
    /**
     * Set the service provider namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Applications\Store';

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
        // Bind Store services
        $this->app->bind(StoreRepositoryInterface::class, StoreRepository::class);
        $this->app->bind(StoreServiceInterface::class, StoreService::class);
    }

    /**
     * Map the store routes.
     *
     * @return void
     */
    protected function map()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/Store/api.php'));
    }
}
