@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Basic Section -->
<section id="basic" class="basic section">

	<div class="basic-bg">
		<img src="{{ asset('img/hero-bg-light.webp') }}" alt="">
	</div>

	<div class="container text-center">
		<div class="d-flex flex-column justify-content-center align-items-center">
			<h1 data-aos="fade-up">Plan your <span>Events</span></h1>
			<div class="d-flex mt-3" data-aos="fade-up" data-aos-delay="200">
				@guest
					@if (Route::has('register'))
						<a href="{{ route('register') }}" class="btn-get-started">Register</a>
					@endif
				@endif
			</div>
			<img class="mt-1" src="{{ asset('img/hero-services-img.webp') }}" class="img-fluid basic-img" alt="" data-aos="zoom-out"
				data-aos-delay="300">
		</div>
	</div>

</section><!-- /Basic Section -->
@endsection
