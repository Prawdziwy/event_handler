<div class="card mt-5">
	<div class="card-header d-flex justify-content-between align-items-center">
		<h2>Members</h2>
		@if(Auth::id() === $calendar->owner_id)
			<form method="POST" action="{{ route('calendars.delete', $calendar->id) }}" style="display:inline;">
				@csrf
				@method('DELETE')
				<button type="submit" class="btn btn-danger btn-sm">{{ __('Delete Calendar') }}</button>
			</form>
		@endif
	</div>

	<div class="card-body">
		@if(Auth::id() === $calendar->owner_id)
			<x-calendar-show-members-add :calendar="$calendar" />
		@endif

		@if($members->count() > 0)
			<table class="table table-striped">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Name</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($members as $member)
						<x-calendar-show-members-single :member="$member" :calendar="$calendar" />
					@endforeach
				</tbody>
			</table>
		@else
			<p>No members yet.</p>
		@endif
	</div>
</div>