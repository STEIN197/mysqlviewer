<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\Main;
use App\Models\MySQLUser;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton(Main::class, function($app) {
			return new Main();
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
