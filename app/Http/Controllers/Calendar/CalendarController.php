<?php
namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCalendarRequest;
use App\Http\Requests\AddMemberRequest;
use App\Models\Calendar;
use App\Models\User;
use App\Services\CalendarServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class CalendarController extends Controller
{
    protected CalendarServiceInterface $calendarService;

    public function __construct(CalendarServiceInterface $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    public function index(): View
    {
        $authUserId = Auth::id();

        $user = User::findOrFail($authUserId);

        $calendars = $this->calendarService->getUserCalendars($user);

        return view('pages.calendars.index', compact('calendars'));
    }

    public function create(): View
    {
        return view('pages.calendars.create');
    }

    public function show(Calendar $calendar): View
    {
        $this->authorize('access', $calendar);

        $members = $calendar->members->map(function ($member) use ($calendar) {
            $member->isOwner = $member->id === $calendar->owner_id;
            return $member;
        })->sortBy(fn($member) => $member->isOwner ? '0' : '1' . $member->name);

        $events = $calendar->events->map(fn($event) => [
            'title' => $event->name,
            'start' => $event->start_date,
            'end' => $event->end_date,
            'id' => $event->id,
            'calendar_id' => $event->calendar_id
        ]);

        return view('pages.calendars.show', compact('calendar', 'members', 'events'));
    }

    public function store(StoreCalendarRequest $request): RedirectResponse
    {
        $calendar = $this->calendarService->createCalendar($request->validated());

        return redirect()->route('calendars.index')
            ->with('success', sprintf('Calendar %s created successfully.', $calendar->name));
    }

    public function addMember(AddMemberRequest $request, Calendar $calendar): RedirectResponse
    {
        $this->authorize('access', $calendar);

        try {
            $this->calendarService->addMember($calendar, $request->member_email);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['member_email' => $e->getMessage()]);
        }

        return redirect()->route('calendars.show', $calendar)
            ->with('success', sprintf('User added successfully.'));
    }

    public function removeMember(Calendar $calendar, int $memberId): RedirectResponse
    {
        $this->authorize('access', $calendar);
        $this->calendarService->removeMember($calendar, $memberId);

        return redirect()->route('calendars.show', $calendar)
            ->with('success', 'Member removed successfully.');
    }

    public function leaveCalendar(Calendar $calendar): RedirectResponse
    {
        $this->authorize('access', $calendar);

        try {
            $this->calendarService->leaveCalendar($calendar, Auth::id());
        } catch (\Exception $e) {
            return redirect()->route('calendars.show', $calendar)
                ->withErrors($e->getMessage());
        }

        return redirect()->route('calendars.index')
            ->with('success', 'You have left the calendar.');
    }

    public function deleteCalendar(Calendar $calendar): RedirectResponse
    {
        $this->authorize('access', $calendar);
        $this->calendarService->deleteCalendar($calendar);

        return redirect()->route('calendars.index')
            ->with('success', 'Calendar deleted successfully.');
    }
}

