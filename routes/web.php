<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ApiController;
use App\Http\Middleware\Main;
use Illuminate\Http\Request;

Route::middleware(Main::class)->group(function() {
	Route::prefix('api')->group(function() {
		Route::get('/', [ApiController::class, 'index']);
		Route::get('db', function(Request $request) {
			return 1;
		});
	});
	Route::get('/', [LoginController::class, 'index']);
	Route::post('/', [LoginController::class, 'login']);
});
