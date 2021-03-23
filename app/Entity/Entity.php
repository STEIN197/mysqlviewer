<?php

namespace App\Entity;

use \Exception;
use Illuminate\Support\Facades\DB;

abstract class Entity {

	protected array $data;

	public function __construct(array $data) {
		$this->data = $data;
	}

	public function data(): array {
		return $this->data;
	}

	public function truncate(): void {}

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

	public static final function types(): array {
		$discardPatterns = [
			'.', '..', substr(__FILE__, strlen(__DIR__))
		];
		return
			array_map(
				function($v) {
					return strtolower(explode('.', $v)[0]);
				},
				array_filter(
					scandir(__DIR__),
					function($v) use ($discardPatterns) {
						return !in_array($v, $discardPatterns);
					}
				)
			);
	}

	public static final function getClass(string $type): ?string {
		$className = '\\App\\Entity\\'.ucfirst(strtolower($type));
		return class_exists($className) ? $className : null;
	}

	public abstract function id(): string;
	public abstract function delete(): void;
	public abstract function update(array $data): void;
	
	public static abstract function create(array $data): ?Entity;
	public static abstract function read(string $id, array $data = []): ?Entity;

	protected static abstract function listQuery(array $data): string;
}
