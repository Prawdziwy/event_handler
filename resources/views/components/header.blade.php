<header id="header" class="header d-flex align-items-center fixed-top">
	<div class="container-fluid container-xl position-relative d-flex align-items-center">

		<a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
			<img src="{{ asset('img/logo.png') }}" alt="">
		</a>

		<nav id="navmenu" class="navmenu">
			<ul>
				<li><a href="{{ url('/') }}">Home</a></li>
				<li><a href="{{ url('faq') }}">FAQ</a></li>
				@guest
					@if (Route::has('login'))
						<li class="nav-item">
							<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
						</li>
					@endif
				@endguest
			</ul>
			<i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
		</nav>

		@guest
			@if (Route::has('register'))
				<a class="btn-getstarted" href="{{ route('register') }}">Register</a>
			@endif
		@else
			<div class="nav-item dropdown">
				<a id="navbarDropdown" class="btn btn-getstarted dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
					aria-haspopup="true" aria-expanded="false" v-pre>
					{{ Auth::user()->name }}
				</a>

				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<!-- Profile -->
					@if (Route::has('pages.profile.show'))
						<a class="dropdown-item" href="{{ route('pages.profile.show') }}">
							{{ __('Profile') }}
						</a>
					@endif
					<!-- Logout -->
					<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
																										document.getElementById('logout-form').submit();">
						{{ __('Logout') }}
					</a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
						@csrf
					</form>
				</div>
			</div>
		@endguest

	</div>
</header>