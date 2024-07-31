<?php
namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\CalendarEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CalendarEventController extends Controller
{
    public function store(Request $request, Calendar $calendar): RedirectResponse
    {
        $this->authorizeCalendarAccess($calendar);

        $this->validateEvent($request);

        $calendar->events()->create($request->only(['name', 'start_date', 'end_date']));
        return redirect()->route('calendars.show', $calendar);
    }

    public function destroy(Calendar $calendar, CalendarEvent $event): JsonResponse
    {
        $this->authorizeCalendarAccess($calendar);

        $this->authorizeEvent($calendar, $event);

        $event->delete();
        return response()->json(['success' => true]);
    }

    private function authorizeCalendarAccess(Calendar $calendar): void
    {
        $user = Auth::user();

        if (!$calendar->members->contains($user->id) && $calendar->owner_id !== $user->id) {
            abort(403, 'You do not have access to this calendar.');
        }
    }

    private function authorizeEvent(Calendar $calendar, CalendarEvent $event): void
    {
        if ($event->calendar_id !== $calendar->id) {
            abort(404, 'Event not found.');
        }
    }

    private function validateEvent(Request $request): void
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            abort(422, $validator->errors()->first());
        }
    }
}
