<?php
	namespace App;

	use PDO;

	class PDOWrapper {

		protected $pdo;

		public function getPdo(): PDO {
			if (!$this->pdo && $user = session()->get('user')) {
				$connection = env('DB_CONNECTION', 'mysql');
				$host = env('DB_HOST', 'localhost');
				$port = env('DB_PORT', '3306');
				$this->pdo = new PDO("{$connection}:host={$host};port={$port}", $user->getAuthIdentifier(), $user->getAuthPassword());
			}
			return $this->pdo;
		}
	}
