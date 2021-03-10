<?php

namespace App\Models;

use \Exception;
use Illuminate\Support\Facades\DB;

abstract class Entity {

	public static array $_COLUMNS = [];
	public static array $_ACTIONS = [];

	protected array $data;

	protected function __construct(array $data) {
		$this->data = $data;
	}

	public function data(): array {
		return $this->data;
	}

	public function __get(string $property) {
		if (isset($this->data[$property]))
			return $this->data[$property];
		throw new Exception("No property with name '{$property}'");
	}

	public function __set(string $property, $value) {
		$this->data[$property] = $value;
	}

	public static function list(array $data = []): array {
		$result = DB::select(static::listQuery($data));
		$list = [];
		foreach ($result as $row)
			$list[] = new static((array) $row);
		return $list;
	}

	public abstract function id(): string;
	public abstract function delete(): void;
	public abstract function update(array $data): void;
	
	public static abstract function create(array $data): ?Entity;
	public static abstract function read(string $id, array $data = []): ?Entity;

	protected static abstract function listQuery(array $data): string;
}
