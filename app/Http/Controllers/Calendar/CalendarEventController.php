<?php
namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\CalendarEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreEventRequest;

class CalendarEventController extends Controller
{
    public function store(StoreEventRequest $request, Calendar $calendar): RedirectResponse
    {
        $this->authorize('access', $calendar);

        $calendar->events()->create($request->validated());
        return redirect()->route('calendars.show', $calendar);
    }

    public function destroy(Calendar $calendar, CalendarEvent $event): JsonResponse
    {
        $this->authorize('verifyCalendar', [$event, $calendar]);

        $event->delete();
        return response()->json(['success' => true]);
    }
}
