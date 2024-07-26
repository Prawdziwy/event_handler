@extends('layouts.app')

@section('content')
<section id="page">
	<div class="container">
		<div class="card mt-5">
			<div class="card-header text-center">
				<h1>{{ $calendar->name }}</h1>
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
	</div>
</section>
@endsection

@push('scripts')
@vite('resources/js/calendar.js')
@endpush
