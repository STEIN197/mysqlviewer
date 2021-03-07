<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Page;
use App\Models\Schema;

class SchemaController extends Controller {

	public function index(Request $request) {
		return Page::new('schema_index')->withData([
			'schemas' => DB::select(DB::raw("SELECT * FROM `information_schema`.`SCHEMATA`"))
		])->render();
	}

	public function new(Request $request) {
		return Page::new('schema_new')->withData([
			'columns' => [
				'SCHEMA_NAME', 'DEFAULT_CHARACTER_SET_NAME', 'DEFAULT_COLLATION_NAME'
			],
			'charsets' => Schema::charsets(),
			'collations' => Schema::collations()
		])->render();
	}

	public function create(Request $request) {
		Schema::create($request->all());
		return redirect()->route('admin.schema.index');
	}

	public function read(Request $request, string $id) {
		$schema = Schema::read([
			'SCHEMA_NAME' => $id
		]);
		if (!$schema)
			return abort(404);
		$data = $schema->getData();
		unset($data['CATALOG_NAME'], $data['SQL_PATH']);
		return Page::new('schema_read')->withData([
			'data' => $data,
			'charsets' => Schema::charsets(),
			'collations' => Schema::collations()
		])->render();
	}

	public function update(Request $request, string $id) {
		$schema = Schema::read([
			'SCHEMA_NAME' => $id
		]);
		if (!$schema)
			return abort(404);
		$schema->update($request->all());
		return redirect()->action([self::class, 'read'], ['id' => (string) $schema]);
	}

	public static function delete(string $id) {
		Schema::read(['SCHEMA_NAME' => $id])->delete();
		return back();
	}
}
