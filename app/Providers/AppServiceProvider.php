<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('components.add-event-form', 'add-event-form');
        Blade::component('components.members-list', 'members-list');
        Blade::component('components.calendar-header', 'calendar-header');
        Blade::component('components.calendar-view', 'calendar-view');
    }

}
