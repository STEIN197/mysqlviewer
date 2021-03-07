<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Page;
use App\Models\Table;

class TableController extends Controller {

	public function delete(Request $request, string $name, string $schema) {
		Table::read([
			'TABLE_NAME' => $name,
			'TABLE_SCHEMA' => $schema
		])->delete();
		return redirect()->route('admin.schema.table', ['id' => $request->TABLE_SCHEMA]);
	}

	public function truncate(Request $request, string $schema, string $name) {
		Table::read([
			'TABLE_SCHEMA' => $schema,
			'TABLE_NAME' => $name
		])->truncate();
		return redirect()->route('admin.schema.table', ['id' => $schema]);
	}
}
