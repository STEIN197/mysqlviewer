<?php
namespace App;

final class Util {

	private static array $_BOOL_MAP = [
		// '1' => '0',
		'true' => 'false',
		'on' => 'off',
		'yes' => 'no',
		'y' => 'n'
	];

	private function __construct() {}

	public static function isBool(string $value): bool {
		$value = strtolower($value);
		return in_array($value, array_merge(array_keys(self::$_BOOL_MAP), self::$_BOOL_MAP));
	}

	public static function toBool(string $value): ?bool {
		$value = strtolower($value);
		return self::isBool($value) ? isset(self::$_BOOL_MAP[$value]) : null;
	}
}
