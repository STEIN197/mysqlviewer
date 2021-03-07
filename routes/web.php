<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SchemaController;
use App\Http\Controllers\UserController;
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
	
	Route::middleware(Authenticate::class)->group(function () {
		Route::get('/', [LoginController::class, 'index'])->name('index');
		Route::prefix('admin')->group(function () {

			Route::get('/', [AdminController::class, 'index'])->name('admin');
			Route::name('admin.')->group(function () {

				Route::prefix('user')->group(function () {
					Route::get('/', [UserController::class, 'index'])->name('user.index');
					Route::get('/{name}/', [UserController::class, 'read'])->name('user.read');
					Route::post('/{name}/', [UserController::class, 'update'])->name('user.update');
				});

				Route::prefix('schema')->group(function () {
					Route::get('/', [SchemaController::class, 'index'])->name('schema.index');
					Route::get('/{name}/', [SchemaController::class, 'read'])->name('schema.read');
					Route::post('/{name}/', [SchemaController::class, 'update'])->name('schema.update');
					// Route::get('/{name}/table/', [SchemaController::class, 'tables'])->name('schema.table');
				});

				Route::get('/vars/', [AdminController::class, 'vars'])->name('vars');
				Route::get('/engines/', [AdminController::class, 'engines'])->name('engines');
				Route::get('/encodings/', [AdminController::class, 'encodings'])->name('encodings');
				Route::get('/sql/', [AdminController::class, 'sql'])->name('sql');

				Route::prefix('new')->group(function () {
					Route::name('new.')->group(function() {
						Route::get('/user/', [UserController::class, 'new'])->name('user');
						Route::post('/user/', [UserController::class, 'create']);

						Route::get('/schema/', [SchemaController::class, 'new'])->name('schema');
						Route::post('/schema/{name}', [SchemaController::class, 'create']);
					});
				});
			
				Route::prefix('delete')->group(function () {
					Route::name('delete.')->group(function() {
						Route::get('/schema/{name}', [SchemaController::class, 'delete'])->name('schema');
						Route::get('/user/{name}', [UserController::class, 'delete'])->name('user');
					});
				});
			});
		});
	});
});
