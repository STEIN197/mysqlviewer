<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ApiController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\Main;

Route::middleware(Main::class)->group(function() {
	Route::prefix('api')->group(function() {
		Route::get('/', [ApiController::class, 'index']);
		Route::get('db', function(Request $request) {
			return 1;
		});
	});
	Route::get('/', [LoginController::class, 'index'])->name('index');
	Route::post('/', [LoginController::class, 'login']);
	Route::get('/logout/', [LoginController::class, 'logout'])->name('logout');

	Route::middleware(Authenticate::class)->group(function() {
		Route::get('/home/', function() {
			echo 'home';
		});
	});
});
