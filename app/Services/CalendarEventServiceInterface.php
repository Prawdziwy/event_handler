<?php
namespace App\Services;

use App\Models\Calendar;
use App\Models\CalendarEvent;
use Illuminate\Http\Request;

interface CalendarEventServiceInterface
{
	public function storeEvent(Request $request, Calendar $calendar): CalendarEvent;
	public function deleteEvent(Calendar $calendar, CalendarEvent $event): bool;
}
