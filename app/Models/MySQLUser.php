<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class MySQLUser extends Model implements Authenticatable {

	private $name;
	private $password;
	private $rememberToken;

	public function __construct($name, $password, $rememberToken = '') {
		$this->name = $name;
		$this->password = $password;
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

	public static function retrieveByCredentials(array $credentials): ?self {
		try {
			$connection = env('DB_CONNECTION', 'mysql');
			$host = env('DB_HOST', 'localhost');
			$port = env('DB_PORT', '3306');
			$pdo = new \PDO("{$connection}:host={$host};port={$port}", $credentials['username'], $credentials['password']);
			$user = new self($credentials['username'], $credentials['password']);
			session()->put('user', $user);
			return $user;
		} catch (\PDOException $ex) {
			return null;
		}
	}
}
