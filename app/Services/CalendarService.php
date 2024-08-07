<?php
namespace App\Services;

use App\Models\Calendar;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CalendarService implements CalendarServiceInterface
{
	public function getUserCalendars(User $user)
	{
		return Calendar::withCount('members')
			->where('owner_id', $user->id)
			->orWhereHas('members', fn($query) => $query->where('user_id', $user->id))
			->get();
	}

	public function createCalendar(array $data): Calendar
	{
		$data['owner_id'] = Auth::id();
		return Calendar::create($data);
	}

	public function addMember(Calendar $calendar, string $email)
	{
		$user = User::where('email', $email)->firstOrFail();

		if ($calendar->members->contains($user)) {
			throw new \Exception('User is already a member of this calendar.');
		}

		$calendar->members()->attach($user->id);
	}

	public function removeMember(Calendar $calendar, int $memberId)
	{
		$calendar->members()->detach($memberId);
	}

	public function leaveCalendar(Calendar $calendar, int $userId)
	{
		if ($calendar->owner_id === $userId) {
			throw new \Exception('Owner cannot leave their own calendar.');
		}

		$calendar->members()->detach($userId);
	}

	public function deleteCalendar(Calendar $calendar)
	{
		$calendar->delete();
	}
}
