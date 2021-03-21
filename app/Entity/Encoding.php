<?php

namespace App\Entity;

class Encoding extends Entity {

	public static array $_COLUMNS = [
		'COLLATION_NAME', 'DESCRIPTION', 'MAXLEN'
	];
	public static array $_ACTIONS = [];

	public function id(): string {
		return $this->CHARACTER_SET_NAME;
	}

	public function delete(): void {}

	public function update(array $data): void {}

	public static function create(array $data): ?Entity {
		return null;
	}

	public static function read(string $id, array $data = []): ?Entity {
		return null;
	}

	protected static function listQuery(array $data = []): string {
		return <<<SQL
		SELECT
			*
		FROM
			`information_schema`.`CHARACTER_SETS`
				LEFT JOIN
			`information_schema`.`COLLATIONS`
				ON
					`CHARACTER_SETS`.`CHARACTER_SET_NAME` = `COLLATIONS`.`CHARACTER_SET_NAME`
		ORDER BY
			`CHARACTER_SETS`.`CHARACTER_SET_NAME`,
			`COLLATIONS`.`COLLATION_NAME`
		SQL;
	}
}
