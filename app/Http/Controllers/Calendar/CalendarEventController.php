<?php
namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Models\Calendar;
use App\Models\CalendarEvent;
use App\Services\CalendarEventServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class CalendarEventController extends Controller
{
    protected CalendarEventServiceInterface $calendarEventService;

    public function __construct(CalendarEventServiceInterface $calendarEventService)
    {
        $this->calendarEventService = $calendarEventService;
    }

    public function store(StoreEventRequest $request, Calendar $calendar): RedirectResponse
    {
        $this->authorize('access', $calendar);

        $this->calendarEventService->storeEvent($request, $calendar);

        return redirect()->route('calendars.show', $calendar);
    }

    public function destroy(Calendar $calendar, CalendarEvent $event): JsonResponse
    {
        $this->authorize('verifyCalendar', [$event, $calendar]);

        $this->calendarEventService->deleteEvent($calendar, $event);

        return response()->json(['success' => true]);
    }
}

