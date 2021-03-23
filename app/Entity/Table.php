<?php

namespace App\Entity;

use Generator;
use Illuminate\Support\Facades\DB;
use \Illuminate\Database\Connection;

class Table extends Entity {

	public function id(): string {
		return $this->TABLE_NAME;
	}

	public function schema(): Schema {
		return Schema::read($this->TABLE_SCHEMA);
	}

	public function delete(): void {
		$this->connection()->statement("DROP TABLE IF EXISTS `{$this->TABLE_NAME}`");
	}

	public function update(array $data): void {
		if ($data['TABLE_NAME'] && $data['TABLE_NAME'] !== $this->TABLE_NAME)
			$this->rename($data['TABLE_NAME']);
		if ($data['ENGINE'] && $data['ENGINE'] !== $this->ENGINE)
			$this->setEngine($data['ENGINE']);
		if ($data['TABLE_COLLATION'] && $data['TABLE_COLLATION'] !== $this->TABLE_COLLATION)
			$this->setCollation($data['TABLE_COLLATION']);
		// TODO: columns
		$this->data = array_merge($this->data, $data);
	}

	public function truncate(): void {
		$this->connection()->statement("TRUNCATE TABLE `{$this->TABLE_NAME}`");
	}

	public function rows(): Generator {
		$result = $this->connection()->select("SELECT * FROM `{$this->TABLE_NAME}`");
		foreach ($result as $row)
			yield new Row((array) $row);
	}

	public function columns(): Generator {
		$result = DB::select("SELECT * FROM `information_schema`.`COLUMNS` WHERE TABLE_NAME = '{$this->TABLE_NAME}' AND TABLE_SCHEMA = '{$this->TABLE_SCHEMA}' ORDER BY `ORDINAL_POSITION`");
		foreach ($result as $row)
			yield new Column((array) $row);
	}

	public function hasPrimaryKey(): bool {
		$result = DB::select("SELECT * FROM `information_schema`.`TABLE_CONSTRAINTS` WHERE TABLE_NAME = '{$this->TABLE_NAME}' AND TABLE_SCHEMA = '{$this->TABLE_SCHEMA}' AND CONSTRAINT_TYPE = 'PRIMARY KEY'");
		return sizeof($result) > 0;
	}

	private function connection(): Connection {
		$dbName = strtolower($this->TABLE_SCHEMA);
		return DB::connection("mysql:{$dbName}");
	}

	private function rename(string $name): void {
		$this->connection()->statement("RENAME TABLE `{$this->id()}` TO `{$name}`");
	}

	private function setEngine(string $engine): void {
		$this->connection()->statement("ALTER TABLE `{$this->id()}` ENGINE = `{$engine}`");
	}

	private function setCollation(string $collation): void {
		$this->connection()->statement("ALTER TABLE `{$this->id()}` DEFAULT COLLATE = `{$collation}`");
	}

	// TODO
	public static function create(array $data): ?Table {}

	public static function read(string $id, array $data = []): ?Table {
		$data = DB::select("SELECT * FROM `information_schema`.`TABLES` WHERE TABLE_NAME = '".addslashes($id)."' AND TABLE_SCHEMA = '".addslashes(@$data['schema'])."'");
		return $data && sizeof($data) === 1 ? new self((array) $data[0]) : null;
	}

	protected static function listQuery(array $data = []): string {
		return "SELECT * FROM `information_schema`.`TABLES`";
	}
}
