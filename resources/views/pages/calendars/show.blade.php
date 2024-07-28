@extends('layouts.app')

@section('content')
<section id="page">
	<div class="container">
		<div class="card mt-5">
			<div class="card-header text-center">
				<h1>Calendar {{ $calendar->name }}</h1>
				<p class="text-muted mt-2">
					<strong>Owner:</strong> <span class="text-primary">{{ $calendar->owner->name }}</span>
				</p>
			</div>
		</div>

		<div class="card mt-5">
			<div class="card-header">
				<h2>Members</h2>
			</div>

			<div class="card-body">
				@if($calendar->members->count() > 0)
					<table class="table table-striped">
						<thead class="thead-dark">
							<tr>
								<th scope="col">Name</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($calendar->members as $member)
								<tr>
									<td>{{ $member->name }}</td>
									<td>
										<button class="btn btn-secondary btn-sm">Placeholder button</button>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				@else
					<p>No members yet.</p>
				@endif
			</div>
		</div>

		<div class="card mt-5">
			<div class="card-header">
				<h2>Calendar</h2>
			</div>

			<div class="card-body text-webkit-center">
				<div id="calendar"></div>
			</div>
		</div>

		<div class="card mt-5">
			<div class="card-header">
				<h2>Add new event</h2>
			</div>

			<div class="card-body">
				<form method="POST" action="{{ route('calendars.events.store', $calendar) }}">
					@csrf

					<div class="row mb-3">
						<label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

						<div class="col-md-6">
							<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
								value="{{ old('name') }}" required autofocus>

							@error('name')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
					</div>

					<div class="row mb-3">
						<label for="start_date" class="col-md-4 col-form-label text-md-end">{{ __('Start date') }}</label>

						<div class="col-md-6">
							<input id="start_date" type="datetime-local" class="form-control @error('start_date') is-invalid @enderror"
								name="start_date" value="{{ old('start_date') }}" required autocomplete="off">

							@error('start_date')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
					</div>

					<div class="row mb-3">
						<label for="end_date" class="col-md-4 col-form-label text-md-end">{{ __('End date') }}</label>

						<div class="col-md-6">
							<input id="end_date" type="datetime-local" class="form-control @error('end_date') is-invalid @enderror"
								name="end_date" value="{{ old('end_date') }}" required autocomplete="off">

							@error('end_date')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
					</div>

					<div class="row mb-0 justify-content-center">
						<div class="col-md-1">
							<button type="submit" class="btn btn-primary">
								{{ __('Submit') }}
							</button>
						</div>
					</div>
				</form>
			</div>

		</div>
	</div>

	</div>
</section>
@endsection

@push('scripts')
	@vite('resources/js/calendar.js')
@endpush