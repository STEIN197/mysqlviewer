<?php

namespace App\Http\Middleware;

use Closure;
use PDO;
use Illuminate\Http\Request;
use App\PDOWrapper;

class Main {

    public function handle(Request $request, Closure $next) {
		if (session()->get('locale'))
			app()->setLocale(session()->get('locale'));
		if (session()->get('user') && resolve(PDOWrapper::class)->getPdo()) {
			$this->setConnections();
		}
        return $next($request);
	}
	
	public function setConnections(): void {
		$dbConfig = [];
		$user = session()->get('user');
		$protocol = env('DB_CONNECTION', 'mysql');
		$host = env('DB_HOST', 'localhost');
		$port = env('DB_PORT', '3306');
		$pdo = app()->make(PDOWrapper::class)->getPdo();
		foreach ($pdo->query('SHOW DATABASES') as $row) {
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
		$dbConfig['mysql'] = [
			'driver' => env('DB_CONNECTION', 'mysql'),
			'host' => env('DB_HOST', 'localhost'),
			'port' => env('DB_PORT', '3306'),
			'database' => $user->getDatabase() ?? array_values($dbConfig)[0]['database'],
			'username' => $user->getAuthIdentifier(),
			'password' => $user->getAuthPassword(),
			'charset' => 'utf8mb4',
			'collation' => 'utf8mb4_unicode_ci',
		];
		config(['database.connections' => $dbConfig]);
	}

	// public function getPdo(): PDO {

	// }
}
