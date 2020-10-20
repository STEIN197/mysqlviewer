<?php
	namespace App\Http\Middleware;

	use Illuminate\Http\Request;
	use Closure;

	class Authenticate {

		public function handle(Request $request, Closure $next) {
			if (!session()->get('user'))
				return redirect()->route('index');
			else
				$next($request);
		}
	}
