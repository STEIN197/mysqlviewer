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
			case 'create': {
				return $this->renderActionCreate();
			}
			case 'read': {
				return $this->renderActionRead();
			}
			case 'update': {
				return $this->renderActionUpdate();
			}
			default: {
				return null;
			}
		}
	}

	protected function renderActionCreate(): string {
		return '';
	}

	protected function renderActionRead(): string {
		return '';
	}

	protected function renderActionUpdate(): string {
		return '';
	}

	public static function route(string $action, array $data): string {
		return '';
	}

	public abstract function indexActions(): array;
	public abstract function indexColumns(): array;
}
