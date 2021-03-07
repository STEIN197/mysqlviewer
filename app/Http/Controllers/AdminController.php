<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Page;

class AdminController extends Controller {

	public function index(Request $request) {
		return Page::new('admin')->render();
	}

	public function vars(Request $request) {
		return Page::new('vars')->withData([
			'variables' => DB::select(DB::raw('SHOW VARIABLES'))
		])->render();
	}

	public function engines(Request $request) {
		return Page::new('engines')->withData([
			'engines' => DB::select(DB::raw('SELECT * FROM `information_schema`.`ENGINES`'))
		])->render();
	}

	public function encodings(Request $request) {
		$encodings = DB::select(DB::raw('SELECT * FROM `information_schema`.`CHARACTER_SETS` ORDER BY `CHARACTER_SET_NAME`'));
		foreach ($encodings as &$encoding) {
			$encoding->collations = DB::select(DB::raw("SELECT `COLLATION_NAME` FROM `information_schema`.`COLLATIONS` WHERE `CHARACTER_SET_NAME` = '{$encoding->CHARACTER_SET_NAME}' ORDER BY `COLLATION_NAME`"));
		}
		return Page::new('encodings')->withData([
			'encodings' => $encodings
		])->render();
	}

	// TODO
	public function schema(Request $request, $name) {
		return $this->index($request);
	}
	// TODO
	public function tables(Request $request, $name) {
		return $this->index($request);
	}
	// TODO
	public function views(Request $request, $name) {
		return $this->index($request);
	}

	public function sql(Request $request) {
		return Page::new('sql')->render();
	}
}
