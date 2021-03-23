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

	public static function formatBytes(int $bytes): string {
		static $powers = [
			'B',
			'KB',
			'MB',
			'GB',
			'TB',
		];
		$size = $bytes;
		$i = 0;
		while ($size > 1024) {
			$size /= 1024;
			$i++;
		}
		return "{$size} {$powers[$i]}";
	}
}
