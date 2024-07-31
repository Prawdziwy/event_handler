<?php
namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCalendarRequest;
use App\Http\Requests\AddMemberRequest;
use App\Models\Calendar;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class CalendarController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $calendars = Calendar::withCount('members')
            ->where('owner_id', $user->id)
            ->orWhereHas('members', fn($query) => $query->where('user_id', $user->id))
            ->get();

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
        $calendar = Calendar::create([
            'name' => $request->name,
            'owner_id' => Auth::id(),
        ]);

        return redirect()->route('calendars.index')
            ->with('success', sprintf('Calendar %s created successfully.', $calendar->name));
    }

    public function addMember(AddMemberRequest $request, Calendar $calendar): RedirectResponse
    {
        $this->authorize('access', $calendar);

        $user = User::where('email', $request->member_email)->firstOrFail();

        if ($calendar->members->contains($user)) {
            return redirect()->back()->withErrors(['member_email' => 'User is already a member of this calendar.']);
        }

        $calendar->members()->attach($user->id);

        return redirect()->route('calendars.show', $calendar)
            ->with('success', sprintf('User %s added successfully.', $user->name));
    }

    public function removeMember(Calendar $calendar, int $memberId): RedirectResponse
    {
        $this->authorize('access', $calendar);

        $calendar->members()->detach($memberId);

        return redirect()->route('calendars.show', $calendar)
            ->with('success', 'Member removed successfully.');
    }

    public function leaveCalendar(Calendar $calendar): RedirectResponse
    {
        $this->authorize('access', $calendar);

        $userId = Auth::id();

        if ($calendar->owner_id === $userId) {
            return redirect()->route('calendars.show', $calendar)
                ->withErrors('Owner cannot leave their own calendar.');
        }

        $calendar->members()->detach($userId);

        return redirect()->route('calendars.index')
            ->with('success', 'You have left the calendar.');
    }

    public function deleteCalendar(Calendar $calendar): RedirectResponse
    {
        $this->authorize('access', $calendar);

        $calendar->delete();

        return redirect()->route('calendars.index')
            ->with('success', 'Calendar deleted successfully.');
    }
}
