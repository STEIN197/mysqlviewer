<?php
	namespace App\Http\Middleware;

	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Route;
	use Closure;

	class Authenticate {

		public function handle(Request $request, Closure $next) {
			if (auth()->check())
				return strpos(Route::currentRouteName(), 'admin') === 0 ? $next($request) : redirect()->route('admin');
			else
				return strpos(Route::currentRouteName(), 'admin') === 0 ? redirect()->route('index') : $next($request);
		}
	}
