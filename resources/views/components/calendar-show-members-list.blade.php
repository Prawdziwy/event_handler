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
