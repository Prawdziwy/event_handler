<?php

namespace App\Providers;
use App\Models\Calendar;
use App\Models\CalendarEvent;
use App\Policies\CalendarPolicy;
use App\Policies\CalendarEventPolicy;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Calendar::class => CalendarPolicy::class,
        CalendarEvent::class => CalendarEventPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
