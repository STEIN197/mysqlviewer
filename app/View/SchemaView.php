<?php
namespace App\View;

class SchemaView extends EntityView {
	
	public function indexActions(): array {
		return [
			'create', 'update', 'delete'
		];
	}

	public function indexColumns(): array {
		return [
			'SCHEMA_NAME' => [],
			'DEFAULT_CHARACTER_SET_NAME' => [],
			'DEFAULT_COLLATION_NAME' => []
		];
	}
}
