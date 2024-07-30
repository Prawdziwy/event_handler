<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class FilterErrors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $filteredErrors = null;
        $errors = Session::get('errors');
        if ($errors) {
            $filteredErrors = [];

            foreach ($errors->messages() as $key => $errors) {
                if (is_numeric($key)) {
                    foreach ($errors as $error) {
                        $filteredErrors[] = $error;
                    }
                }
            }
        }

        Session::flash('filtered_errors', $filteredErrors);
        return $response;
    }
}
