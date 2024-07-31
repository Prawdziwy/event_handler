<div class="card mt-5">
	<div class="card-header">
		<h2>Calendar</h2>
	</div>

	<div class="card-body text-webkit-center">
		<div id="calendar"></div>
	</div>
</div>

@push('scripts')
	<script>
		window.calendarEvents = @json($events);
	</script>

	@vite('resources/js/calendar.js')
@endpush