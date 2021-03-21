<?php
namespace App\View;

class VariableView extends EntityView {

	public function columns(): array {
		return [
			'Variable_name',
			'Value'
		]
	}
}
