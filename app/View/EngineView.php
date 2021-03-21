<?php
namespace App\View;

class EngineView extends EntityView {

	public function indexActions(): array {
		return [];
	}
	
	public function indexColumns(): array {
		return [
			'COMMENT' => [],
			'SUPPORT' => [],
			'TRANSACTIONS' => []
		];
	}
}
