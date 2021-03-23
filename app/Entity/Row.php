<?php

namespace App\Entity;

use Illuminate\Support\Facades\DB;
use \Illuminate\Database\Connection;

class Row extends Entity {

	// TODO
	public function id(): string {
		return '';
	}

	// TODO
	public function delete(): void {}

	// TODO
	public function update(array $data): void {}

	// TODO
	public static function create(array $data): ?Row {}

	public static function read(string $id, array $data = []): ?Row {
		$data = DB::select("SELECT * FROM `information_schema`.`TABLES` WHERE TABLE_NAME = '".addslashes($id)."' AND TABLE_SCHEMA = '".addslashes($data['TABLE_SCHEMA'])."'");
		return $data && sizeof($data) === 0 ? new self((array) $data[0]) : null;
	}

	protected static function listQuery(array $data = []): string {
		return "";
	}
}
