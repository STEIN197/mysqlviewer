<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Entity\Entity;

class EntityExistance {

    public function handle(Request $request, Closure $next) {
		return Entity::getClass($request->type) ? $next($request) : abort(404);
	}
}
