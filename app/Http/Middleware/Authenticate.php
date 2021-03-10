<?php
	namespace App\Http\Middleware;

	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Route;
	use Closure;

	class Authenticate {

		public function handle(Request $request, Closure $next) {
			$isAdminRoute = in_array(Route::currentRouteName(), [
				'admin', 'index', 'create', 'read', 'update', 'delete'
			]);
			if (auth()->check())
				return $isAdminRoute ? $next($request) : redirect()->route('admin');
			else
				return $isAdminRoute ? redirect()->route('home') : $next($request);
		}
	}
