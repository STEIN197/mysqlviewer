<?php
namespace App\View;

use App\Entity\Entity;

abstract class EntityView {

	protected ?Entity $entity;

	public function __construct(?Entity $entity = null) {
		$this->entity = $entity;
	}

	public static final function getClass(string $type): ?string {
		$className = '\\App\\View\\'.ucfirst(strtolower($type)).'View';
		return class_exists($className) ? $className : null;
	}

	public function editableProperties(): array {
		return [];
	}

	public function renderAction(string $action): string {
		switch (strtolower($action)) {
			case 'read': {
				return $this->renderActionRead();
			}
			default: {
				return null;
			}
		}
	}

	protected function renderActionRead(): string {
		return '';
	}
	
	public abstract function indexActions(): array;
	public abstract function indexColumns(): array;
}
