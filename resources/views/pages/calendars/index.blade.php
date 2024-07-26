@extends('layouts.app')

@section('content')
<section id="page">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">{{ __('Calendars') }}</div>

					<div class="card-body">
						@if($calendars->isNotEmpty())
							<x-calendar-table :calendars="$calendars" />
						@else
							<x-calendars-empty />
						@endif

						<x-calendar-create-button />
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection