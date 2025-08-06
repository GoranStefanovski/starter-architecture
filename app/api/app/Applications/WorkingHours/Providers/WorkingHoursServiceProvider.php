<?php

namespace App\Applications\WorkingHours\Providers;

use App\Applications\WorkingHours\Repositories\WorkingHoursRepository;
use App\Applications\WorkingHours\Repositories\WorkingHoursRepositoryInterface;
use App\Applications\WorkingHours\Services\WorkingHoursService;
use App\Applications\WorkingHours\Services\WorkingHoursServiceInterface;
use Illuminate\Support\ServiceProvider;

class WorkingHoursServiceProvider extends ServiceProvider
{
    /**
     * Set the service provider namespace
     *
     */
    protected $namespace = 'App\Applications\WorkingHours';
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(WorkingHoursRepositoryInterface::class, WorkingHoursRepository::class);
        $this->app->bind(WorkingHoursServiceInterface::class, WorkingHoursService::class);
    }

}
