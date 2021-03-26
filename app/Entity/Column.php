<?php

namespace App\Entity;

use App\Util;
use \Exception;
use Illuminate\Support\Facades\DB;

class Column extends Entity {

	public function id(): string {
		return $this->COLUMN_NAME;
	}

	public function delete(): void {
		DB::statement("ALTER TABLE `{$this->TABLE_SCHEMA}`.`{$this->TABLE_NAME}` DROP COLUMN `{$this->id()}`");
	}

	// TODO
	public function update(array $data): void {
		if (strtolower($data['DATA_TYPE']) !== $this->DATA_TYPE)
			$this->setType($data['DATA_TYPE'], (int) $data['SIZE']);
		if ($data['COLUMN_DEFAULT'] !== $this->COLUMN_DEFAULT)
			$this->setDefault($data['COLUMN_DEFAULT']);
		if ($data['COLUMN_NAME'] && $data['COLUMN_NAME'] !== $this->COLUMN_NAME)
			$this->rename($data['COLUMN_NAME']);
		if ($data['AUTO_INCREMENT'])
			$this->setAutoIncrement();
		if ($data['COLLATION_NAME'] !== $this->COLLATION_NAME)
			$this->setCollation($data['COLLATION_NAME']);
		if ((bool) $data['IS_NULLABLE'] !== Util::toBool($this->IS_NULLABLE))
			$this->setNullable((bool) $data['IS_NULLABLE']);
		// TODO: set index/primary
		$this->data = array_merge($this->data, $data);
	}

	private function rename(string $name): void {
		DB::statement("ALTER TABLE `{$this->TABLE_SCHEMA}`.`{$this->TABLE_NAME}` RENAME COLUMN `{$this->id()}` TO `{$name}`");
		$this->COLUMN_NAME = $name;
	}

	private function setType(string $type, ?int $size = null): void {
		DB::statement("ALTER TABLE `{$this->TABLE_SCHEMA}`.`{$this->TABLE_NAME}` MODIFY COLUMN `{$this->id()}` {$type}".($size ? "({$size})" : ''));
	}

	private function setDefault(string $value): void {
		DB::statement("ALTER TABLE `{$this->TABLE_SCHEMA}`.`{$this->TABLE_NAME}` MODIFY COLUMN `{$this->id()}` DEFAULT ".(Util::isNumeric($value) ? $value : "'{$value}'"));
	}

	private function setAutoIncrement(): void {
		DB::statement("ALTER TABLE `{$this->TABLE_SCHEMA}`.`{$this->TABLE_NAME}` MODIFY COLUMN `{$this->id()}` AUTO_INCREMENT");
	}

	private function setCollation(string $collation): void {
		DB::statement("ALTER TABLE `{$this->TABLE_SCHEMA}`.`{$this->TABLE_NAME}` MODIFY COLUMN `{$this->id()}` COLLATE `{$collation}`");
	}

	private function setNullable(bool $value): void {
		DB::statement("ALTER TABLE `{$this->TABLE_SCHEMA}`.`{$this->TABLE_NAME}` MODIFY COLUMN `{$this->id()}` ".($value ? 'NULL' : 'NOT NULL'));
	}
	
	// TODO
	public static function create(array $data): ?Column {
		// DB::statement("ALTER TABLE `{$data['schema']}`.`{$data['table']}` ADD COLUMN `{$data['COLUMN_NAME']}`");
		// return self::read($data['COLUMN_NAME'], $data);
	}

	public static function read(string $id, array $data = []): ?Column {
		$result = DB::select("SELECT * FROM `information_schema`.`COLUMNS` WHERE `COLUMN_NAME` = '{$id}' AND `TABLE_NAME` = '{$data['table']}' AND `TABLE_SCHEMA` = '{$data['schema']}'");
		return $result && sizeof($result) === 1 ? new self((array) $result[0]) : null;
	}

	public static function dataTypes(): array {
		return [
			'TINYINT',
			'SMALLINT',
			'MEDIUMINT',
			'INT',
			'BIGINT',
			'DECIMAL',
			'NUMERIC',
			'FLOAT',
			'DOUBLE',
			'YEAR',
			'BIT',
			'DATE',
			'DATETIME',
			'TIMESTAMP',
			'TIME',
			'TINYTEXT',
			'TEXT',
			'MEDIUMTEXT',
			'LONGTEXT',
			'SET',
			'ENUM',
			'CHAR',
			'VARCHAR',
		];
	}

	protected static function listQuery(array $data): string {
		return '';
	}
}
