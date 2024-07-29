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