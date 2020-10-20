<?php

namespace App\Http\Middleware;

use Closure;
use PDO;
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
		if (session()->get('user')) {
			$this->setConnections();
			$this->setDefaultConnection();
		}
        return $next($request);
	}
	
	public function setConnections(): void {
		$dbConfig = [];
		$user = session()->get('user');
		$protocol = env('DB_CONNECTION', 'mysql');
		$host = env('DB_HOST', 'localhost');
		$port = env('DB_PORT', '3306');
		$connect = new PDO("{$protocol}:host={$host};port={$port}", $user->getAuthIdentifier(), $user->getAuthPassword());
		foreach ($connect->query('SHOW DATABASES') as $row) {
			$dbConfig["mysql:{$row['Database']}"] = [
				'driver' => $protocol,
				'host' => $host,
				'port' => $port,
				'database' => $row['Database'],
				'username' => $user->getAuthIdentifier(),
				'password' => $user->getAuthPassword(),
				'charset' => 'utf8mb4',
				'collation' => 'utf8mb4_unicode_ci',
			];
		}
		config(['database.connections' => $dbConfig]);
	}

	public function setDefaultConnection(): void {
		$user = session()->get('user');
		config('database.connections.default', [
			'driver' => env('DB_CONNECTION', 'mysql'),
			'host' => env('DB_HOST', 'localhost'),
			'port' => env('DB_PORT', '3306'),
			'database' => $user->getDatabase(),
			'username' => $user->getAuthIdentifier(),
			'password' => $user->getAuthPassword(),
			'charset' => 'utf8mb4',
			'collation' => 'utf8mb4_unicode_ci',
		]);
	}
}
