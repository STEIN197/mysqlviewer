<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use \Illuminate\Database\Connection;

class Table extends Entity {

	public function delete(): void {
		$this->connection()->statement("DROP TABLE IF EXISTS `{$this->TABLE_NAME}`");
	}

	public function update(array $data): void {} // TODO

	public function truncate(): void {
		$this->connection()->statement("TRUNCATE TABLE `{$this->TABLE_NAME}`");
	}

	public function __toString(): string {
		return $this->TABLE_NAME;
	}

	private function connection(): Connection {
		return DB::connection("mysql:{$this->TABLE_SCHEMA}");
	}

	public static function create(array $data): ?Table {} // TODO

	public static function read(array $data): ?Table {
		$data = DB::select("SELECT * FROM `information_schema`.`TABLES` WHERE TABLE_NAME = '{$data['TABLE_NAME']}' AND TABLE_SCHEMA = '{$data['TABLE_SCHEMA']}'");
		return $data ? new self((array) $data[0]) : null;
	}
}
