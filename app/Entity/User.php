<?php

namespace App\Entity;

use Illuminate\Support\Facades\DB;

class User extends Entity {

	private static array $_PRIVILEGES_MAP = [
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
		'proxies_priv' => 'PROXY',
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
	private static array $_LIMITS_MAP = [
		'max_questions' => 'MAX_QUERIES_PER_HOUR',
		'max_updates' => 'MAX_UPDATES_PER_HOUR',
		'max_connections' => 'MAX_CONNECTIONS_PER_HOUR',
		'max_user_connections' => 'MAX_USER_CONNECTIONS',
	];

	public function id(): string {
		return "{$this->User}@{$this->Host}";
	}

	public function delete(): void {
		DB::statement("DROP USER {$this->sqlId()}");
	}

	public function update(array $data): void {
		$this->updateLimits($data);
		$this->updatePrivileges($data);
		$this->updateCredentials($data);
		$this->data = array_merge($this->data, $data);
	}

	private function updateCredentials(array $data): void {
		if ($data['Password'])
			DB::statement("ALTER USER {$this->sqlId()} IDENTIFIED BY ".addslashes($data['Password']));
		$fullNameChanged = $data['User'] !== $this->User || $data['Host'] !== $this->Host;
		if ($fullNameChanged)
			DB::statement("RENAME USER {$this->sqlId()} TO '".addslashes($data['User']).'\'@\''.addslashes($data['Host']).'\'');
	}

	private function updateLimits(array $data): void {
		$limits = [];
		foreach ($data as $col => $value) {
			if (!preg_match('/^max_/', $col) || ((float) $this->data[$col]) == ((float) $value) || !@self::$_LIMITS_MAP[$col])
				continue;
			$limits[] = self::$_LIMITS_MAP[$col]." {$value}";
		}
		if ($limits)
			DB::statement("ALTER USER {$this->sqlId()} WITH ".join(' ', $limits));
	}

	private function updatePrivileges(array $data): void {
		$grants = $revokes = [];
		foreach ($this->getPrivileges() as $privKey => $privValue) {
			if ($privValue === 'Y' && !@$data[$privKey] && @self::$_PRIVILEGES_MAP[$privKey])
				$revokes[] = self::$_PRIVILEGES_MAP[$name];
		}
		foreach ($data as $key => $value) {
			if (!preg_match('/_priv$/', $key) || $this->{$key} === ($value ? 'Y' : 'N') || !@self::$_PRIVILEGES_MAP[$key])
				continue;
			$grants[] = self::$_PRIVILEGES_MAP[$key];
		}
		if ($grants)
			DB::statement('GRANT '.join(', ', $grants)." ON *.* TO {$this->sqlId()}");
		if ($revokes)
			DB::statement('REVOKE '.join(', ', $revokes)." ON *.* FROM {$this->sqlId()}");
	}

	private function getPrivileges(): array {
		$result = [];
		foreach ($this->data as $key => $value)
			if (preg_match('/_priv$/', $key))
				$result[$key] = $value;
		return $result;
	}

	private function sqlId(): string {
		return
			join(
				'@',
				array_map(
					function($part) {
						return "'{$part}'";
					},
					explode('@', $this->id())
				)
			);
	}
	
	public static function create(array $data): ?User {
		$name = "'".addslashes($data['User'])."'@'".addslashes($data['Host'])."'";
		$password = addslashes($data['Password']);
		$result = DB::statement("CREATE USER {$name} IDENTIFIED BY '{$password}'");
		$user = self::read("{$data['User']}@{$data['Host']}");
		$user->updateLimits($data);
		$user->updatePrivileges($data);
		return $user;
	}

	public static function read(string $id, array $data = []): ?User {
		[$user, $host] = explode('@', $id);
		$data = DB::select('SELECT * FROM `mysql`.`user` WHERE User = \''.addslashes($user).'\' AND Host = \''.addslashes($host).'\'');
		return $data ? new self((array) $data[0]) : null;
	}

	protected static function listQuery(array $data): string {
		return 'SELECT * FROM mysql.user';
	}
}
