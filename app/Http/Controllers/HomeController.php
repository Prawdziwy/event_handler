<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index(): View
	{
		return view('pages.home');
	}

	public function faq(): View
	{
		return view('pages.faq');
	}
}
