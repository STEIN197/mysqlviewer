<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\Main;

Route::middleware(Main::class)->group(function() {
	Route::prefix('api')->group(function() {
		Route::get('/', [ApiController::class, 'index']);
		Route::get('db', function(Request $request) {
			return 1;
		});
	});
	Route::get('/logout/', [LoginController::class, 'logout'])->name('logout');
	
	Route::middleware(Authenticate::class)->group(function() {
		Route::get('/', [LoginController::class, 'index'])->name('index');
		Route::post('/', [LoginController::class, 'login']);
		Route::prefix('admin')->group(function() {
			Route::get('/', [AdminController::class, 'index'])->name('admin');
			Route::name('admin.')->group(function() {
				Route::get('/tables/', [AdminController::class, 'tables'])->name('tables');
				Route::get('/sql/', [AdminController::class, 'sql'])->name('sql');
			});
		});
	});
});
