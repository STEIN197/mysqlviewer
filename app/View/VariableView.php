<?php
namespace App\View;

class VariableView extends EntityView {

	public function indexColumns(): array {
		return [
			'Variable_name' => [],
			'Value' => []
		];
	}

	public function indexActions(): array {
		return [];
	}
}