<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Services\CalendarServiceInterface;
use App\Services\CalendarService;
use App\Services\CalendarEventServiceInterface;
use App\Services\CalendarEventService;
use App\Services\ProfileServiceInterface;
use App\Services\ProfileService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CalendarServiceInterface::class, CalendarService::class);
        $this->app->bind(CalendarEventServiceInterface::class, CalendarEventService::class);
        $this->app->bind(ProfileServiceInterface::class, ProfileService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Calendars
        Blade::components([
            'components.calendar.calendars-empty' => 'calendars-empty',
            'components.calendar.create-button' => 'calendar-create-button',
            'components.calendar.show-add-event' => 'calendar-show-add-event-form',
            'components.calendar.show-calendar' => 'calendar-show',
            'components.calendar.show-info' => 'calendar-show-info',
            'components.calendar.show-members-list' => 'calendar-show-members-list',
            'components.calendar.show-members-single' => 'calendar-show-members-single',
            'components.calendar.show-members-add' => 'calendar-show-members-add',
            'components.calendar.table' => 'calendar-table',
        ]);

        // Profile
        Blade::components([
            'components.profile.edit-form' => 'profile-edit-form',
            'components.profile.edit-password-form' => 'profile-edit-password-form',
        ]);

        // Home
        Blade::components([
            'components.home.get-started' => 'home-get-started',
            'components.home.more-features' => 'home-more-features',
        ]);
    }

}
