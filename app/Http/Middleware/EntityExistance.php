<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Entity\Entity;

class EntityExistance {

	public function handle(Request $request, Closure $next) {
		$className = Entity::getClass($request->type);
		$is404 = !$className || $request->id && !$className::read($request->id, $request->all());
		return $is404 ? abort(404) : $next($request);
	}
}
