<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Calendar;
use Illuminate\Auth\Access\HandlesAuthorization;

class CalendarPolicy
{
    use HandlesAuthorization;

    public function access(User $user, Calendar $calendar)
    {
        return $calendar->members->contains($user->id) || $calendar->owner_id === $user->id;
    }
}
