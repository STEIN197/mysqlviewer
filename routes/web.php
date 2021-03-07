<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SchemaController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RowController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\EntityController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\Main;

// function entityTypes(): array {
// 	return [
// 		'user' => UserController::class,
// 		'table' => TableController::class,
// 		'schema' => SchemaController::class,
// 		'column' => ColumnController::class,
// 		'row' => RowController::class
// 	];
// }

function crud(): array {
	return [
		'create', 'read', 'update', 'delete'
	];
}

Route::middleware(Main::class)->group(function() {
	Route::prefix('api')->group(function() {
		Route::get('/', [ApiController::class, 'index']);
	});

	Route::get('/logout/', [LoginController::class, 'logout'])->name('logout');
	Route::any('/login/', [LoginController::class, 'login'])->name('login');
	
	Route::middleware(Authenticate::class)->group(function () {
		Route::get('/', [LoginController::class, 'index'])->name('index');
		Route::prefix('admin')->group(function () {

			Route::get('/', [AdminController::class, 'index'])->name('admin');
			Route::name('admin.')->group(function () {

				Route::get('/vars/', [AdminController::class, 'vars'])->name('vars');
				Route::get('/engines/', [AdminController::class, 'engines'])->name('engines');
				Route::get('/encodings/', [AdminController::class, 'encodings'])->name('encodings');
				Route::get('/sql/', [AdminController::class, 'sql'])->name('sql');

				Route::get("/{type}/", [EntityController::class, 'index'])->name("index");
				foreach (crud() as $action) {
					Route::get("/{$action}/{type}/{id?}", [EntityController::class, $action])->name("{$action}");
					Route::post("/{$action}/{type}/{id?}", [EntityController::class, $action]);
				}
			});
		});
	});
});
