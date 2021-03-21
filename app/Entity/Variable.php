<?php

namespace App\Entity;

use Illuminate\Support\Facades\DB;

class Variable extends Entity {

	public static array $_COLUMNS = [
		'Value'
	];
	public static array $_ACTIONS = [];

	public function id(): string {
		return $this->Variable_name;
	}

	public function delete(): void {} // TODO
	public function update(array $data): void {} // TODO
	public static function create(array $data): ?Variable {} // TODO
	public static function read(string $id, array $data = []): ?Variable {} // TODO

	protected static function listQuery(array $data = []): string {
		return 'SHOW VARIABLES';
	}
}
