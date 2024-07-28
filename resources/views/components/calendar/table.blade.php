<table class="table table-striped">
	<thead>
		<tr>
			<th scope="col">Name</th>
			<th scope="col">Amount of Members</th>
		</tr>
	</thead>
	<tbody>
		@foreach($calendars as $calendar)
			<tr class='clickable-row' data-href='{{ route('calendars.show', $calendar->id) }}'>
				<td>{{ $calendar->name }}</td>
				<td>{{ $calendar->members_count }}</td>
			</tr>
		@endforeach
	</tbody>
</table>