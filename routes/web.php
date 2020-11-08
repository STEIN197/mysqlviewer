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
		Route::get('/database/{name}/', function(Request $request) {
			return 1;
		});
	});
	Route::get('/logout/', [LoginController::class, 'logout'])->name('logout');
	Route::any('/login/', [LoginController::class, 'login'])->name('login');
	
	Route::middleware(Authenticate::class)->group(function() {
		Route::get('/', [LoginController::class, 'index'])->name('index');
		Route::prefix('admin')->group(function() {
			Route::get('/', [AdminController::class, 'index'])->name('admin');
			Route::name('admin.')->group(function() {
				Route::get('/users/', [AdminController::class, 'users'])->name('users');
				Route::get('/vars/', [AdminController::class, 'vars'])->name('vars');
				Route::get('/engines/', [AdminController::class, 'engines'])->name('engines');
				Route::get('/encodings/', [AdminController::class, 'encodings'])->name('encodings');

				Route::get('/schemas/', [AdminController::class, 'schemas'])->name('schemas');
				Route::get('/schemas/{name}/', [AdminController::class, 'schema'])->name('schema');
				Route::get('/schemas/{name}/tables/', [AdminController::class, 'tables'])->name('tables');
				Route::get('/schemas/{name}/views/', [AdminController::class, 'views'])->name('views');

				Route::get('/sql/', [AdminController::class, 'sql'])->name('sql');
			});
		});
	});
});
