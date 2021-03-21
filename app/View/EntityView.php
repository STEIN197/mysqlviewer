<?php
namespace App\View;

abstract class EntityView {

	public static final function getClass(string $type): ?string {
		$className = '\\App\\View\\'.ucfirst(strtolower($type)).'View';
		return class_exists($className) ? $className : null;
	}
	
	public abstract function indexActions(): array;
	public abstract function indexColumns(): array;
}
