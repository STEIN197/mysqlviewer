<?php
namespace App\View;

abstract class EntityView {

	public static final function getClass(string $type): ?string {
		$className = '\\App\\View\\'.ucfirst(strtolower($type));
		return class_exists($className) ? $className : null;
	}
	
	public abstract function columns(): array;
	// public abstract function actions(): array;
}
