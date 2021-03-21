<?php

namespace App\Entity;

use Illuminate\Support\Facades\DB;
use \Illuminate\Database\Connection;

class Table extends Entity {

	public function delete(): void {
		$this->connection()->statement("DROP TABLE IF EXISTS `{$this->TABLE_NAME}`");
	}

	public function update(array $data): void {
		if ($data['TABLE_NAME'] !== $this->TABLE_NAME)
			$this->rename($data['TABLE_NAME']);
		$this->data = array_merge($this->data, $data);
	} // TODO

	public function truncate(): void {
		$this->connection()->statement("TRUNCATE TABLE `{$this->TABLE_NAME}`");
	}

	public function rows(): array {
		return $this->connection()->select("SELECT * FROM `{$this->TABLE_NAME}`");
	}

	public function columns(): array {
		$result = DB::select("SELECT * FROM `information_schema`.`COLUMNS` WHERE TABLE_NAME = '{$this->TABLE_NAME}' AND TABLE_SCHEMA = '{$this->TABLE_SCHEMA}' ORDER BY ORDINAL_POSITION");
		return array_combine(
			array_column(
				array_map(
					function ($v) {
						return (array) $v;
					},
					$result
				),
				'COLUMN_NAME'
			),
			$result
		);
	}

	public function hasPrimaryKey(): bool {
		$result = DB::select("SELECT * FROM `information_schema`.`TABLE_CONSTRAINTS` WHERE TABLE_NAME = '{$this->TABLE_NAME}' AND TABLE_SCHEMA = '{$this->TABLE_SCHEMA}' AND CONSTRAINT_TYPE = 'PRIMARY KEY'");
		return sizeof($result) > 0;
	}

	public function __toString(): string {
		return $this->TABLE_NAME;
	}

	private function connection(): Connection {
		$dbName = strtolower($this->TABLE_SCHEMA);
		return DB::connection("mysql:{$dbName}");
	}

	private function rename(string $name): void {
		$this->connection()->statement("RENAME TABLE `{$this->TABLE_NAME}` TO `{$name}`");
	}

	public static function create(array $data): ?Table {} // TODO

	public static function read(array $data): ?Table {
		$data = DB::select("SELECT * FROM `information_schema`.`TABLES` WHERE TABLE_NAME = '{$data['TABLE_NAME']}' AND TABLE_SCHEMA = '{$data['TABLE_SCHEMA']}'");
		return $data ? new self((array) $data[0]) : null;
	}
}
