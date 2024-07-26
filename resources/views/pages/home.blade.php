@extends('layouts.app')

@section('title', 'Home')

@section('content')
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
				@else
					@if (Route::has('calendars.index'))
						<a href="{{ route('calendars.index') }}" class="btn-get-started">Calendars</a>
					@endif
				@endif
			</div>
			<img class="mt-1" src="{{ asset('img/hero-services-img.webp') }}" class="img-fluid basic-img" alt=""
				data-aos="zoom-out" data-aos-delay="300">
		</div>
	</div>

</section>

<section id="more-features" class="more-features section">

	<div class="container">

		<div class="row justify-content-around gy-4">

			<div class="col-lg-6 d-flex flex-column justify-content-center order-2 order-lg-1" data-aos="fade-up"
				data-aos-delay="100">
				<h3>Enim quis est voluptatibus aliquid consequatur</h3>
				<p>Esse voluptas cumque vel exercitationem. Reiciendis est hic accusamus. Non ipsam et sed minima temporibus
					laudantium. Soluta voluptate sed facere corporis dolores excepturi</p>

				<div class="row">

					<div class="col-lg-6 icon-box d-flex">
						<i class="bi bi-easel flex-shrink-0"></i>
						<div>
							<h4>Lorem Ipsum</h4>
							<p>Voluptatum deleniti atque corrupti quos dolores et quas molestias </p>
						</div>
					</div><!-- End Icon Box -->

					<div class="col-lg-6 icon-box d-flex">
						<i class="bi bi-patch-check flex-shrink-0"></i>
						<div>
							<h4>Nemo Enim</h4>
							<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiise</p>
						</div>
					</div><!-- End Icon Box -->

					<div class="col-lg-6 icon-box d-flex">
						<i class="bi bi-brightness-high flex-shrink-0"></i>
						<div>
							<h4>Dine Pad</h4>
							<p>Explicabo est voluptatum asperiores consequatur magnam. Et veritatis odit</p>
						</div>
					</div><!-- End Icon Box -->

					<div class="col-lg-6 icon-box d-flex">
						<i class="bi bi-brightness-high flex-shrink-0"></i>
						<div>
							<h4>Tride clov</h4>
							<p>Est voluptatem labore deleniti quis a delectus et. Saepe dolorem libero sit</p>
						</div>
					</div><!-- End Icon Box -->

				</div>

			</div>

			<div class="features-image col-lg-5 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="200">
				<img src="{{ asset('img/features-3.jpg') }}" alt="">
			</div>

		</div>

	</div>

</section>

@endsection