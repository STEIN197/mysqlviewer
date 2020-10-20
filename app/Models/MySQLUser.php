<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class MySQLUser extends Model implements Authenticatable {

	protected $server;
	protected $name;
	protected $password;
	protected $database;
	protected $rememberToken;

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

	public static function retrieveByCredentials(array $credentials): ?self {
		try {
			$connection = env('DB_CONNECTION', 'mysql');
			$host = env('DB_HOST', 'localhost');
			$port = env('DB_PORT', '3306');
			$user = new self($credentials['username'], $credentials['password'], $credentials['database'], $credentials['host']);
			$pdo = new \PDO("{$connection}:host={$host};port={$port}", $user->getAuthIdentifier(), $user->getAuthPassword());
			session()->put('user', $user);
			return $user;
		} catch (\PDOException $ex) {
			return null;
		}
	}
}
