<?php

namespace App\Entity;

use Illuminate\Support\Facades\DB;
use \Illuminate\Database\Connection;

class Row extends Entity {

	private Table $table;

	public function __construct(array $data, Table $table) {
		parent::__construct($data);
		$this->table = $table;
	}

	public function id(): string {
		return $this->data[$this->table->primaryKey()->id()];
	}

	public function delete(): void {
		DB::statement("DELETE FROM `{$this->table->TABLE_SCHEMA}`.`{$this->table->id()}` WHERE `{$this->table->primaryKey()->id()}` = '{$this->id()}'");
	}

	// TODO
	public function update(array $data): void {
		$columns = $this->table()->columns();
		$q = "UPDATE `{$this->table()->TABLE_SCHEMA}`.`{$this->table->id()}` SET ";
		$aQ = [];
		foreach ($columns as $column) {
			if ($column->DATA_TYPE === 'set') {
				$aQ[] = "`{$column->id()}` = '".join(',', array_map(function ($v): string {
					return addslashes($v);
				}, $data[$column->id()]))."'";
			} else {
				$aQ[] = "`{$column->id()}` = '".addslashes($data[$column->id()])."'";
			}
		}
		$q .= join(', ', $aQ);
		$q .= " WHERE `{$this->table()->primaryKey()->id()}` = '".addslashes($this->id())."'";
		DB::statement($q);
		$this->data = array_merge($this->data, $data);
	}

	public function table(): Table {
		return $this->table;
	}

	// TODO: Добавить проветку буленов
	public static function create(array $data): ?Row {
		$table = Table::read($data['table'], $data);
		$columns = $table->columns();
		$q = "INSERT INTO `{$table->TABLE_SCHEMA}`.`{$table->id()}` ";
		$colQ = $valQ = [];
		foreach ($columns as $column) {
			if (!$data[$column->id()])
				continue;
			$colQ[] = $column->id();
			if ($column->DATA_TYPE === 'set') {
				$valQ[] = "'".join(',', array_map(function ($v): string {
					return addslashes($v);
				}, $data[$column->id()]))."'";
			} else {
				$valQ[] = "'".addslashes($data[$column->id()])."'";
			}
		}
		if (!$colQ)
			return null;
		$q .= '('.join(', ', array_map(function ($v): string {
			return "`{$v}`";
		}, $colQ)).')';
		$q .= ' VALUES ('.join(', ', $valQ).')';
		DB::statement($q);
		return $table->hasPrimaryKey() ? new self($data, $table) : null;
	}

	public static function read(string $id, array $data = []): ?Row {
		if (!$data['schema'] || !$data['table'])
			return null;
		$table = Table::read($data['table'], $data);
		if (!$table || !$table->primaryKey())
			return null;
		$data = DB::select("SELECT * FROM `{$data['schema']}`.`{$data['table']}` WHERE `{$table->primaryKey()->id()}` = '".addslashes($id)."'");
		return $data && sizeof($data) === 1 ? new self((array) $data[0], $table) : null;
	}

	protected static function listQuery(array $data = []): string {
		return "";
	}
}
