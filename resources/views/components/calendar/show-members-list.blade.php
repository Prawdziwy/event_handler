<div class="card mt-5">
	<div class="card-header">
		<h2>Members</h2>
	</div>

	<div class="card-body">
		<form method="POST" action="{{ route('calendars.add-member', $calendar->id) }}">
			@csrf
			<div class="row mb-3">
				<label for="member_email" class="col-md-4 col-form-label text-md-end">{{ __('Add Member by Email') }}</label>
				<div class="col-md-6">
					<input id="member_email" type="email" class="form-control @error('member_email') is-invalid @enderror"
						name="member_email" value="{{ old('member_email') }}" required>
					@error('member_email')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
				</div>
				<div class="col-md-2">
					<button type="submit" class="btn btn-primary">{{ __('Add') }}</button>
				</div>
			</div>
		</form>

		@if($calendar->members->count() > 0)
			<table class="table table-striped">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Name</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ $calendar->owner->name }} (Owner)</td>
						<td></td>
					</tr>
					@foreach($calendar->members->sortBy('name') as $member)
						@if($member->id !== $calendar->owner->id)
							<tr>
								<td>{{ $member->name }}</td>
								<td>
									<form method="POST" action="{{ route('calendars.remove-member', [$calendar->id, $member->id]) }}"
										style="display:inline;">
										@csrf
										@method('DELETE')
										<button type="submit" class="btn btn-danger btn-sm">{{ __('Remove') }}</button>
									</form>
								</td>
							</tr>
						@endif
					@endforeach
				</tbody>
			</table>
		@else
			<p>No members yet.</p>
		@endif
	</div>
</div>