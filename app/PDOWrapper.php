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

		public static function toBool($value): ?bool {
			if (is_string($value))
				$value = strtolower($value);
			$result = filter_var($value, FILTER_VALIDATE_BOOLEAN);
			if ($result === null) {
				if (in_array($value, ['y']))
					$result = true;
				elseif (in_array($value, ['n']))
					$result = false;
			}
			return $result;
		}
	}
