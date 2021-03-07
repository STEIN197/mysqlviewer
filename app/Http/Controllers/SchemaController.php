<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Page;

class SchemaController extends Controller {

	public function index(Request $request) {
		return Page::new('schema_index')->withData([
			'schemas' => DB::select(DB::raw("SELECT * FROM `information_schema`.`SCHEMATA` WHERE SCHEMA_NAME IN ('".join('\',\'', session()->get('user')->getAccessibleDatabases())."')"))
		])->render();
	}
}
