<?php
namespace App\View;

use App\Entity\Schema;

class SchemaView extends EntityView {
	
	public function indexActions(): array {
		return [
			'create', 'read', 'update', 'delete'
		];
	}

	public function indexColumns(): array {
		return [
			'SCHEMA_NAME' => [],
			'DEFAULT_CHARACTER_SET_NAME' => [],
			'DEFAULT_COLLATION_NAME' => []
		];
	}

	public function editableProperties(): array {
		return [
			'SCHEMA_NAME' => [
				'readonly' => true
			],
			'DEFAULT_COLLATION_NAME' => [
				'type' => 'select',
				'options' => Schema::collations()
			],
			'DEFAULT_CHARACTER_SET_NAME' => [
				'type' => 'select',
				'options' => Schema::charsets()
			]
		];
	}
}
