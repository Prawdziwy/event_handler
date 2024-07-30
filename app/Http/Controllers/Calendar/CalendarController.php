<?php
namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $calendars = Calendar::withCount('members')
            ->where('owner_id', $user->id)
            ->orWhereHas('members', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();

        return view('pages.calendars.index', compact('calendars'));
    }

    public function create()
    {
        return view('pages.calendars.create');
    }

    public function show($id)
    {
        $calendar = Calendar::with('members')->findOrFail($id);
        $user = Auth::user();

        if (!$calendar->members->contains($user->id) && $calendar->owner_id !== $user->id) {
            return redirect()->route('calendars.index')->withErrors('You do not have access to this calendar.');
        }

        $members = $calendar->members->map(function ($member) use ($calendar) {
            $member->isOwner = $member->id === $calendar->owner_id;
            return $member;
        })->sortBy(function ($member) {
            return $member->isOwner ? '0' : '1' . $member->name;
        });

        return view('pages.calendars.show', compact('calendar', 'members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:calendars',
        ]);

        $calendar = Calendar::create([
            'name' => $request->name,
            'owner_id' => Auth::id(),
        ]);

        return redirect()->route('calendars.index')->with('success', sprintf('Calendar %s created successfully.', $calendar->name));
    }

    public function addMember(Request $request, $id)
    {
        $calendar = Calendar::findOrFail($id);

        if (Auth::id() !== $calendar->owner_id) {
            return redirect()->route('calendars.show', $calendar)->withErrors('Only the owner can add members.');
        }

        $request->validate([
            'member_email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->member_email)->first();

        if ($calendar->members->contains($user)) {
            return redirect()->back()->withErrors(['member_email' => 'User is already a member of this calendar.']);
        }

        $calendar->members()->attach($user->id);

        return redirect()->route('calendars.show', $calendar)->with('success', sprintf('User %s added successfully.', $user->name));
    }

    public function removeMember($calendarId, $memberId)
    {
        $calendar = Calendar::findOrFail($calendarId);

        if (Auth::id() !== $calendar->owner_id) {
            return redirect()->route('calendars.show', $calendar)->withErrors('Only the owner can remove members.');
        }

        $calendar->members()->detach($memberId);

        return redirect()->route('calendars.show', $calendar)->with('success', 'Member removed successfully.');
    }

    public function leaveCalendar($calendarId)
    {
        $calendar = Calendar::findOrFail($calendarId);
        $userId = Auth::id();

        if ($calendar->owner_id === $userId) {
            return redirect()->route('calendars.show', $calendar)->withErrors('Owner cannot leave their own calendar.');
        }

        $calendar->members()->detach($userId);

        return redirect()->route('calendars.index')->with('success', 'You have left the calendar.');
    }

    public function deleteCalendar($id)
    {
        $calendar = Calendar::findOrFail($id);

        if (Auth::id() !== $calendar->owner_id) {
            return redirect()->route('calendars.show', $calendar)->withErrors('Only the owner can delete the calendar.');
        }

        $calendar->delete();

        return redirect()->route('calendars.index')->with('success', 'Calendar deleted successfully.');
    }
}
