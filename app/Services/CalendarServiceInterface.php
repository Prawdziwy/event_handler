<?php
namespace App\Services;

use App\Models\Calendar;
use App\Models\User;

interface CalendarServiceInterface
{
    public function getUserCalendars(User $user);
    public function createCalendar(array $data): Calendar;
    public function addMember(Calendar $calendar, string $email);
    public function removeMember(Calendar $calendar, int $memberId);
    public function leaveCalendar(Calendar $calendar, int $userId);
    public function deleteCalendar(Calendar $calendar);
}
