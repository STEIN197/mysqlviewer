<?php
namespace App\View;

abstract class EntityView {

	public static abstract function columns(): array;
	public static abstract function actions(): array;
}
