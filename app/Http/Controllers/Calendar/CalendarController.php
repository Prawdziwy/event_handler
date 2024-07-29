<?php
namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $calendar = Calendar::findOrFail($id);

        return view('pages.calendars.show', compact('calendar'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:calendars',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $calendar = Calendar::create([
            'name' => $request->name,
            'owner_id' => Auth::id(),
        ]);

        return redirect()->route('calendars.index')->with('success', sprintf('Calendar %s created successfully.', $calendar->name));
    }

    public function addMember(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'member_email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $calendar = Calendar::findOrFail($id);
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
        $calendar->members()->detach($memberId);

        return redirect()->route('calendars.show', $calendar)->with('success', 'Member removed successfully.');
    }
}
