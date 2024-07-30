<?php
namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use Illuminate\Http\Request;

class CalendarEventController extends Controller
{
    public function store(Request $request, Calendar $calendar)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $calendar->events()->create($request->all());

        return redirect()->route('calendars.show', $calendar);
    }
}
