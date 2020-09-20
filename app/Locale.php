<?php
	namespace App;

	class Locale {

		public static function getAll(): array {
			$path = resource_path('lang');
			if (file_exists($path) && is_dir($path)) {
				return array_values(array_filter(scandir($path), function($value) {
					return $value !== '.' && $value !== '..';
				}));
			} else {
				return [];
			}
		}

		public static function exists(string $locale): bool {
			return in_array($locale, self::getAll());
		}
	}
