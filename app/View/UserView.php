<?php
namespace App\View;

class UserView extends EntityView {

	public function indexColumns(): array {
		return [
			'User' => [],
			'Host' => [],
		];
	}

	public function indexActions(): array {
		return [
			'delete', 'update', 'create'
		];
	}
}
