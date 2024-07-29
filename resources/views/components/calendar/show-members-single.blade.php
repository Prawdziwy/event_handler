<tr>
	<td>
		{{ $member->name }}{{ $member->isOwner ? ' (Owner)' : '' }}
	</td>
	<td>
		@if(Auth::id() === $calendar->owner_id && !$member->isOwner)
			<form method="POST" action="{{ route('calendars.remove-member', [$calendar->id, $member->id]) }}"
				style="display:inline;">
				@csrf
				@method('DELETE')
				<button type="submit" class="btn btn-danger btn-sm">{{ __('Remove') }}</button>
			</form>
		@elseif(Auth::id() === $member->id && !$member->isOwner)
			<form method="POST" action="{{ route('calendars.leave', $calendar->id) }}" style="display:inline;">
				@csrf
				@method('DELETE')
				<button type="submit" class="btn btn-warning btn-sm">{{ __('Leave') }}</button>
			</form>
		@endif
	</td>
</tr>