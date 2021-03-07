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
		if (!$oTable)
			return abort(404);
		return Page::new('table_rows')->withData([
			'table' => $table,
			'rows' => $oTable->rows(),
			'columns' => $oTable->columns(),
			'primary' => $oTable->hasPrimaryKey()
		])->render();
	}

	public function read(Request $request, string $schema, string $table) {
		$oTable = Table::read(self::dataFromArgs($schema, $table));
		if (!$oTable)
			return abort(404);
		return Page::new('table_read')->withData([
			'data' => $oTable->getData(),
			'columns' => $oTable->columns(),
		])->render();
	}

	public function update(Request $request, string $schema, string $table) {
		$oTable = Table::read(self::dataFromArgs($schema, $table));
		if (!$oTable)
			return abort(404);
		$oTable->update($request->all());
		return redirect()->action([self::class, 'read'], ['id' => $oTable->TABLE_SCHEMA, 'name' => $oTable->TABLE_NAME]);
	}

	private static function dataFromArgs(string $schema, string $table): array {
		return [
			'TABLE_SCHEMA' => $schema,
			'TABLE_NAME' => $table
		];
	}
}
