<?php
namespace App\Services;

use App\Models\Calendar;
use App\Models\CalendarEvent;
use Illuminate\Http\Request;

class CalendarEventService implements CalendarEventServiceInterface
{
	public function storeEvent(Request $request, Calendar $calendar): CalendarEvent
	{
		return $calendar->events()->create($request->validated());
	}

	public function deleteEvent(Calendar $calendar, CalendarEvent $event): bool
	{
		if ($event->calendar_id !== $calendar->id) {
			throw new \Exception('Event does not belong to the calendar');
		}
		return $event->delete();
	}
}
