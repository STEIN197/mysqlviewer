<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\Main;
use App\Models\MySQLUser;
use App\PDOWrapper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton(Main::class, function($app) {
			return new Main;
		});
		$this->app->singleton(PDOWrapper::class, function($app) {
			return new PDOWrapper;
		});
		// $this->app->bind(MySQLUser::class, function($app) {
		// 	return session()->get('user');
		// });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		
    }
}
