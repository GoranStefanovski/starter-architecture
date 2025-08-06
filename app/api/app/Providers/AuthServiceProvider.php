<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Applications\Event\Model\Event;
use App\Applications\Venue\Model\Venue;
use App\Policies\EventPolicy;
use App\Policies\VenuePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Venue::class => VenuePolicy::class,
        Event::class => EventPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
