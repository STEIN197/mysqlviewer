<?php

namespace App\Entity;

use App\Util;
use \Exception;
use Illuminate\Support\Facades\DB;

class Column extends Entity {

	public function __construct(array $data) {
		parent::__construct($data);
		$this->COLUMN_DEFAULT = trim($this->COLUMN_DEFAULT, '\'"');
	}

	public function id(): string {
		return $this->COLUMN_NAME;
	}

	public function delete(): void {
		DB::statement("ALTER TABLE `{$this->TABLE_SCHEMA}`.`{$this->TABLE_NAME}` DROP COLUMN `{$this->id()}`");
	}

	// TODO
	public function update(array $data): void {
		if (strtolower($data['DATA_TYPE']) !== strtolower($this->DATA_TYPE))
			$this->setType($data['DATA_TYPE']);
		if ($data['COLUMN_DEFAULT'] && $data['COLUMN_DEFAULT'] != $this->COLUMN_DEFAULT)
			$this->setDefault($data['COLUMN_DEFAULT']);
		if (@$data['AUTO_INCREMENT'] && $this->EXTRA !== 'auto_increment' && !self::isString($data['DATA_TYPE']))
			$this->setAutoIncrement();
		if ($data['COLLATION_NAME'] !== $this->COLLATION_NAME && self::isString($data['DATA_TYPE']))
			$this->setCollation($data['COLLATION_NAME']);
		if ((bool) @$data['IS_NULLABLE'] !== Util::toBool($this->IS_NULLABLE))
			$this->setNullable((bool) $data['IS_NULLABLE']);
		if ($data['COLUMN_NAME'] && $data['COLUMN_NAME'] !== $this->COLUMN_NAME)
			$this->rename($data['COLUMN_NAME']);
		$this->data = array_merge($this->data, $data);
	}

	private function rename(string $name): void {
		$name = addslashes($name);
		DB::statement("ALTER TABLE `{$this->TABLE_SCHEMA}`.`{$this->TABLE_NAME}` RENAME COLUMN `{$this->id()}` TO `{$name}`");
		$this->COLUMN_NAME = $name;
	}

	private function setType(string $type): void {
		$type = addslashes($type);
		DB::statement("ALTER TABLE `{$this->TABLE_SCHEMA}`.`{$this->TABLE_NAME}` MODIFY COLUMN `{$this->id()}` {$type}");
		$this->DATA_TYPE = $type;
	}

	private function setDefault(string $value): void {
		$value = addslashes($value);
		DB::statement("ALTER TABLE `{$this->TABLE_SCHEMA}`.`{$this->TABLE_NAME}` MODIFY COLUMN `{$this->id()}` {$this->DATA_TYPE} DEFAULT '{$value}'");
	}

	private function setAutoIncrement(): void {
		DB::statement("ALTER TABLE `{$this->TABLE_SCHEMA}`.`{$this->TABLE_NAME}` MODIFY COLUMN `{$this->id()}` {$this->DATA_TYPE} AUTO_INCREMENT");
	}

	private function setCollation(string $collation): void {
		DB::statement("ALTER TABLE `{$this->TABLE_SCHEMA}`.`{$this->TABLE_NAME}` MODIFY COLUMN `{$this->id()}` {$this->DATA_TYPE} COLLATE `{$collation}`");
	}

	private function setNullable(bool $value): void {
		DB::statement("ALTER TABLE `{$this->TABLE_SCHEMA}`.`{$this->TABLE_NAME}` MODIFY COLUMN `{$this->id()}` {$this->DATA_TYPE} ".($value ? 'NULL' : 'NOT NULL'));
	}
	
	// TODO
	public static function create(array $data): ?Column {
		if (!$data['schema'] || !$data['table'] || !$data['COLUMN_NAME'] || !$data['DATA_TYPE'])
			return null;
		$data = $data;
		array_walk($data, function (&$value, $key) {
			$value = addslashes($value);
		});
		$q = "ALTER TABLE `{$data['schema']}`.`{$data['table']}` ADD COLUMN `{$data['COLUMN_NAME']}` {$data['DATA_TYPE']} ";
		$q .= @$data['IS_NULLABLE'] ? 'NULL' : 'NOT NULL';
		if ($data['COLUMN_DEFAULT'])
			$q .= " DEFAULT '{$data['COLUMN_DEFAULT']}'";
		if (@$data['EXTRA'])
			$q .= ' AUTO_INCREMENT';
		if (self::isString($data['DATA_TYPE']))
			$q .= " COLLATE `{$data['COLLATION_NAME']}`";
		DB::statement($q);
		return self::read($data['COLUMN_NAME'], $data);
	}

	public static function read(string $id, array $data = []): ?Column {
		$data = $data;
		array_walk($data, function (&$value) {
			$value = addslashes($value);
		});
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

	public static function isString(string $type): bool {
		return in_array($type, [
			'TINYTEXT',
			'TEXT',
			'MEDIUMTEXT',
			'LONGTEXT',
			'SET',
			'ENUM',
			'CHAR',
			'VARCHAR',
		]);
	}

	protected static function listQuery(array $data): string {
		return '';
	}
}
