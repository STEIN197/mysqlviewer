<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class User extends Entity {


	private static array $privilegesMap = [
		'Alter_priv' => 'ALTER',
		'Alter_routine_priv' => 'ALTER ROUTINE',
		'Create_priv' => 'CREATE',
		'Create_routine_priv' => 'CREATE ROUTINE',
		'Create_tablespace_priv' => 'CREATE TABLESPACE',
		'Create_tmp_table_priv' => 'CREATE TEMPORARY TABLES',
		'Create_user_priv' => 'CREATE USER',
		'Create_view_priv' => 'CREATE VIEW',
		'Delete_priv' => 'DELETE',
		'Drop_priv' => 'DROP',
		'Event_priv' => 'EVENT',
		'Execute_priv' => 'EXECUTE',
		'File_priv' => 'FILE',
		'Grant_priv' => 'GRANT OPTION',
		'Index_priv' => 'INDEX',
		'Insert_priv' => 'INSERT',
		'Lock_tables_priv' => 'LOCK TABLES',
		'Process_priv' => 'PROCESS',
		'proxies_priv' => 'PROXY 	Se',
		'References_priv' => 'REFERENCES',
		'Reload_priv' => 'RELOAD',
		'Repl_client_priv' => 'REPLICATION CLIENT',
		'Repl_slave_priv' => 'REPLICATION SLAVE',
		'Select_priv' => 'SELECT',
		'Show_db_priv' => 'SHOW DATABASES',
		'Show_view_priv' => 'SHOW VIEW',
		'Shutdown_priv' => 'SHUTDOWN',
		'Super_priv' => 'SUPER',
		'Trigger_priv' => 'TRIGGER',
		'Update_priv' => 'UPDATE',
	];
	private static array $limitsMap = [
		'max_questions' => 'MAX_QUERIES_PER_HOUR',
		'max_updates' => 'MAX_UPDATES_PER_HOUR',
		'max_connections' => 'MAX_CONNECTIONS_PER_HOUR',
		'max_user_connections' => 'MAX_USER_CONNECTIONS',
	];

	public function getLogin(): array {
		static $keys = [
			'Host', 'User', 'Password',
		];
		$result = [];
		foreach ($this->data as $col => $value)
			if (in_array($col, $keys))
				$result[$col] = $value;
		return $result;
	}

	public function getLimits(): array {
		$result = [];
		foreach ($this->data as $col => $value)
			if (preg_match('/^max_/', $col))
				$result[$col] = $value;
		return $result;
	}

	public function getPrivileges(): array {
		$result = [];
		foreach ($this->data as $col => $value)
			if (preg_match('/_priv$/', $col))
				$result[$col] = $value;
		return $result;
	}

	public function fullName(bool $escape = false): string {
		return $escape ? self::escape($this->User).'@'.self::escape($this->Host) : "{$this->User}@{$this->Host}";
	}

	public function delete(): void {
		DB::statement('DROP USER '.join('@', array_map('self::escape', [$this->User, $this->Host])));
	}

	public function update(array $data): void {
		$this->updateLimits($data);
		$this->updatePrivileges($data);
		$this->updateCredentials($data);
		$this->data = array_merge($this->data, $data);
	}

	public function __toString(): string {
		return $this->data['User'].'@'.$this->data['Host'];
	}

	private function updateCredentials(array $data): void {
		if ($data['Password'])
			DB::statement("ALTER USER {$this->fullName(true)} IDENTIFIED BY ".self::escape($data['Password']));
		$fullNameChanged = $data['User'] !== $this->User || $data['Host'] !== $this->Host;
		if ($fullNameChanged) {
			DB::statement("RENAME USER {$this->fullName(true)} TO ".self::escape($data['User']).'@'.self::escape($data['Host']));
			$this->User = $data['User'];
			$this->Host = $data['Host'];
		}
	}

	private function updateLimits(array $data): void {
		$limits = [];
		foreach ($data as $col => $value) {
			if (!preg_match('/^max_/', $col) || ((float) $this->data[$col]) == ((float) $value) || !@self::$limitsMap[$col])
				continue;
			$limits[] = self::$limitsMap[$col]." {$value}";
		}
		if ($limits)
			DB::statement("ALTER USER {$this->fullName(true)} WITH ".join(' ', $limits));
	}

	private function updatePrivileges(array $data): void {
		$grants = $revokes = [];
		foreach ($this->getPrivileges() as $name => $value) {
			if ($value === 'Y' && !@$data[$name] && @self::$privilegesMap[$name])
				$revokes[] = self::$privilegesMap[$name];
		}
		foreach ($data as $col => $value) {
			if (!preg_match('/_priv$/', $col) || $this->data[$col] === ($value ? 'Y' : 'N') || !@self::$privilegesMap[$col])
				continue;
			$grants[] = self::$privilegesMap[$col];
		}
		if ($grants)
			DB::statement('GRANT '.join(', ', $grants)." ON *.* TO {$this->fullName(true)}");
		if ($revokes)
			DB::statement('REVOKE '.join(', ', $revokes)." ON *.* FROM {$this->fullName(true)}");
	}

	private static function escape(string $string): string {
		return DB::connection()->getPdo()->quote($string);
	}
	
	public static function create(array $data): ?User {
		$result = DB::statement('CREATE USER '.self::escape($data['User']).'@'.self::escape($data['Host']).' IDENTIFIED BY '.self::escape($data['Password']));
		return $result ? self::read($data) : null;
	}

	public static function read(array $data): ?User {
		$data = DB::select(DB::raw('SELECT * FROM mysql.user WHERE User = '.self::escape($data['User']).' AND Host = '.self::escape($data['Host'])));
		return $data ? new self((array) $data[0]) : null;
	}
}
