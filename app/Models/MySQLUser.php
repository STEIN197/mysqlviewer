<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use App\PDOWrapper;
use PDO;

class MySQLUser extends Model implements Authenticatable {

	protected $host;
	protected $name;
	protected $password;
	protected $database;
	protected $rememberToken;
	protected $accessibleDatabases;

	public function __construct(string $name, ?string $password = null, ?string $database = null, ?string $host = 'localhost', $rememberToken = '') {
		$this->name = $name;
		$this->password = $password;
		$this->database = $database;
		$this->host = $host;
		$this->rememberToken = $rememberToken;
	}
	
	public function getAuthIdentifierName() {
		return null;
	}

    public function getAuthIdentifier() {
		return $this->name;
	}

    public function getAuthPassword() {
		return $this->password;
	}

    public function getRememberToken() {
		return $this->rememberToken;
	}

    public function setRememberToken($value) {
		$this->rememberToken = $value;
	}

    public function getRememberTokenName() {
		return null;
	}

	public function getDatabase(): ?string {
		return $this->database;
	}

	public function getAccessibleDatabases(): array {
		if (!$this->accessibleDatabases)
			$this->accessibleDatabases = array_unique(array_column(config('database.connections'), 'database'));
		return $this->accessibleDatabases;
	}

	public function getHost(): string {
		return $this->host;
	}

	public function isRoot(): bool {
		$pdo = resolve(PDOWrapper::class)->getPdo();
		$pdo->query('USE mysql');
		$mysqlIsAccessible = !$pdo->errorInfo()[1];
		if ($mysqlIsAccessible) {
			$result = $pdo->query("SELECT * FROM `mysql`.`user` WHERE `User` = '{$this->getAuthIdentifier()}' AND `Host` = '{$this->getHost()}'");
			if ($result) {
				$result = $result->fetch(PDO::FETCH_ASSOC);
				return array_reduce(
					array_filter(
						$result,
						function ($v, $k) {
							return preg_match('/_priv$/', $k);
						},
						ARRAY_FILTER_USE_BOTH
					),
					function($carry, $item) {
						return $carry && $item === 'Y';
					},
					true
				);
			}
			return false;
		}
		return false;
	}

	public static function retrieveByCredentials(array $credentials): ?self {
		try {
			$connection = env('DB_CONNECTION', 'mysql');
			$host = env('DB_HOST', 'localhost');
			$port = env('DB_PORT', '3306');
			$user = new self($credentials['username'], $credentials['password'], $credentials['database'], $credentials['host']);
			new PDO("{$connection}:host={$host};port={$port}", $user->getAuthIdentifier(), $user->getAuthPassword());
			return $user;
		} catch (\PDOException $ex) {
			return null;
		}
	}
}
