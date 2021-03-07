<?php

namespace App\Models;

use \Exception;

abstract class Entity {

	protected array $data;

	protected function __construct(array $data) {
		$this->data = $data;
	}

	public function __get(string $property) {
		if (isset($this->data[$property]))
			return $this->data[$property];
		throw new Exception("No property with name '{$property}'");
	}

	public function __set(string $property, $value) {
		$this->data[$property] = $value;
	}

	public abstract function delete(): void;
	public abstract function update(array $data): void;
	
	public static abstract function create(array $data): ?Entity;
	public static abstract function read(array $data): ?Entity;
}
