<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Page;
use App\Models\Table;

class TableController extends Controller {

	public function delete(Request $request, string $schema, string $table) {
		Table::read(self::dataFromArgs($schema, $table))->delete();
		return redirect()->route('admin.schema.table', ['id' => $schema]);
	}

	public function truncate(Request $request, string $schema, string $table) {
		Table::read(self::dataFromArgs($schema, $table))->truncate();
		return redirect()->route('admin.schema.table', ['id' => $schema]);
	}

	public function rows(Request $request, string $schema, string $table) {
		$oTable = Table::read(self::dataFromArgs($schema, $table));
		return Page::new('table_rows')->withData([
			'table' => $table,
			'rows' => $oTable->rows(),
			'columns' => $oTable->columns(),
			'primary' => $oTable->hasPrimaryKey()
		])->render();
	}

	private static function dataFromArgs(string $schema, string $table): array {
		return [
			'TABLE_SCHEMA' => $schema,
			'TABLE_NAME' => $table
		];
	}
}
