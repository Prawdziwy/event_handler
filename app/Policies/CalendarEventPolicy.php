<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Calendar;
use App\Models\CalendarEvent;
use App\Policies\CalendarPolicy;

class CalendarEventPolicy
{
    public function verifyCalendar(User $user, CalendarEvent $event, Calendar $calendar): bool
    {
        $calendarPolicy = app(CalendarPolicy::class);
        return $calendarPolicy->access($user, $calendar) && $event->calendar_id === $calendar->id;
    }
}
