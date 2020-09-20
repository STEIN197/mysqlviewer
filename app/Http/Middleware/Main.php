<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Main
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
		if (session()->get('locale'))
			app()->setLocale(session()->get('locale'));
		$this->setConnections();
        return $next($request);
	}
	
	public function setConnections(): void {
		$dbConfig = [];
		$username = session()->get('database.username');
		$password = session()->get('database.password');
		$connection = env('DB_CONNECTION', 'mysql');
		$host = env('DB_HOST', 'localhost');
		$port = env('DB_PORT', '3306');
		if (!session()->get('database.names'))
			return;
		foreach (session()->get('database.names') as $name) {
			$dbConfig[$name] = [
				'driver' => $connection,
				'host' => $host,
				'port' => $port,
				'database' => $name,
				'username' => $username,
				'password' => $password,
				'charset' => 'utf8mb4',
				'collation' => 'utf8mb4_unicode_ci',
			];
		}
		config(['database.connections' => $dbConfig]);
	}
}
