<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Auth\Guards\MySQLGuard;
use App\Extensions\MySQLUserProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() {
		$this->registerPolicies();
		auth()->provider('mysql', function ($app, array $config) {
            return new MySQLUserProvider;
        });
		auth()->extend('mysql', function ($app) {
            return new MySQLGuard($app['request']);
        });
    }
}
