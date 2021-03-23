<?php

namespace App\Entity;

use Generator;
use Illuminate\Support\Facades\DB;

class Schema extends Entity {

	public function id(): string {
		return $this->SCHEMA_NAME;
	}

	public function delete(): void {
		DB::statement("DROP SCHEMA IF EXISTS `{$this->SCHEMA_NAME}`");
	}

	public function update(array $data): void {
		DB::statement("ALTER SCHEMA `{$this->SCHEMA_NAME}` CHARACTER SET = `{$data['DEFAULT_CHARACTER_SET_NAME']}` COLLATE = `{$data['DEFAULT_COLLATION_NAME']}`");
		$this->data = array_merge($this->data, $data);
	}

	public function truncate(): void {
		$dbName = strtolower($this->SCHEMA_NAME);
		$result = DB::connection("mysql:{$dbName}")->select('SHOW TABLES');
		if (!sizeof($result))
			return;
		$tables = [];
		foreach ($result as $row)
			$tables[] = '`'.$row->{"Tables_in_{$this->SCHEMA_NAME}"}.'`';
		DB::connection("mysql:{$dbName}")->statement('DROP TABLE IF EXISTS '.join(', ', $tables));
	}

	public function tables(): Generator {
		$result = DB::select("SELECT * FROM `information_schema`.`TABLES` WHERE `TABLE_SCHEMA` = '{$this->SCHEMA_NAME}'");
		foreach ($result as $row)
			yield new Table((array) $row);
	}

	public function __toString(): string {
		return $this->SCHEMA_NAME;
	}

	public static function create(array $data): ?Schema {
		$result = DB::statement("CREATE SCHEMA IF NOT EXISTS `{$data['SCHEMA_NAME']}` CHARACTER SET = `{$data['DEFAULT_CHARACTER_SET_NAME']}` COLLATE = `{$data['DEFAULT_COLLATION_NAME']}`");
		return $result ? self::read($data['SCHEMA_NAME']) : null;
	}

	public static function read(string $id, array $data = []): ?Schema {
		$data = DB::select('SELECT * FROM `information_schema`.`SCHEMATA` WHERE SCHEMA_NAME = \''.addslashes($id).'\'');
		return $data ? new self((array) $data[0]) : null;
	}

	public static function charsets(): array {
		return
			array_column(
				array_map(
					function ($v) {
						return (array) $v;
					},
					DB::select('SELECT CHARACTER_SET_NAME FROM `information_schema`.`CHARACTER_SETS` ORDER BY `CHARACTER_SET_NAME`')
				),
				'CHARACTER_SET_NAME'
			);
	}

	public static function collations(): array {
		return
			array_column(
				array_map(
					function ($v) {
						return (array) $v;
					},
					DB::select('SELECT COLLATION_NAME FROM `information_schema`.`COLLATIONS` ORDER BY `COLLATION_NAME`')
				),
				'COLLATION_NAME'
			);
	}

	protected static function listQuery(array $data = []): string {
		return 'SELECT * FROM `information_schema`.`SCHEMATA`';
	}
}
