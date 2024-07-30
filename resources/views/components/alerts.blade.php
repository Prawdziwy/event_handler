@if(session('success'))
	<div class="alert alert-success right-0 mb-3 mr-3">
		{{ session('success') }}
	</div>
@endif

@if(session('filtered_errors'))
	<div class="alert alert-danger right-0 mb-3 mr-3">
		@foreach(session('filtered_errors') as $error)
			<p>{{ $error }}</p>
		@endforeach
	</div>
	@php
		// Couldn't find a better way to forget it after one time, otherwise it shows up twice
		session()->forget('filtered_errors');
		session()->flush();
	@endphp
@endif
