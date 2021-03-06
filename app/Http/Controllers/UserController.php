<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Page;

class UserController extends Controller {

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
	
	private string $name;
	private string $host;
	private array $data;

	public function __construct(string $name, string $host) {
		$this->name = $name;
		$this->host = $host;
		$this->makeData();
	}

	public function getLogin(): array {
		static $keys = [
			'Host', 'User', 'Password',
		];
		$result = [];
		foreach ($this->data as $col => $value) {
			if (in_array($col, $keys))
				$result[$col] = $value;
		}
		return $result;
	}

	public function getLimits(): array {
		$result = [];
		foreach ($this->data as $col => $value) {
			if (preg_match('/^max_/', $col))
				$result[$col] = $value;
		}
		return $result;
	}

	public function getPrivileges(): array {
		$result = [];
		foreach ($this->data as $col => $value) {
			if (preg_match('/_priv$/', $col))
				$result[$col] = $value;
		}
		return $result;
	}

	public function update(array $data) {
		$this->updateLimits($data);
		$this->updatePrivileges($data);
		$this->updateCredentials($data);
		$this->makeData();
		return redirect()->action([AdminController::class, 'user'], ['name' => $this->fullName()]);
	}

	private function updateCredentials(array $data): void {
		if ($data['Password'])
			DB::statement("ALTER USER {$this->fullName(true)} IDENTIFIED BY ".self::escape($data['Password']));
		$fullNameChanged = $data['User'] !== $this->name || $data['Host'] !== $this->host;
		if ($fullNameChanged) {
			DB::statement("RENAME USER {$this->fullName(true)} TO ".self::escape($data['User']).'@'.self::escape($data['Host']));
			$this->name = $data['User'];
			$this->host = $data['Host'];
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

	private function changedCredentials(string $name, string $host): bool {
		return $this->data['User'] !== $name || $this->data['Host'] !== $host;
	}

	private function makeData(): void {
		$this->data = (array) DB::select(DB::raw('SELECT * FROM mysql.user WHERE User = '.self::escape($this->name).' AND Host = '.self::escape($this->host)))[0];
	}

	private function fullName(bool $escape = false): string {
		return $escape ? self::escape($this->name).'@'.self::escape($this->host) : "{$this->name}@{$this->host}";
	}

	private static function escape(string $string): string {
		return DB::connection()->getPdo()->quote($string);
	}
}
