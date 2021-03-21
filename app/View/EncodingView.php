<?php
namespace App\View;

class EncodingView extends EntityView {

	public function indexActions(): array {
		return [];
	}

	public function indexColumns(): array {
		return [
			'COLLATION_NAME' => [],
			'DESCRIPTION' => [],
			'MAXLEN' => []
		];
	}
}
