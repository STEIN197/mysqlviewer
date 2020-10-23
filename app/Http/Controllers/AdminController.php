<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class AdminController extends Controller {

	public function index(Request $request) {
		return Page::new('admin')->render();
	}

	// TODO
	public function users(Request $request) {
		return $this->index($request);
	}
	// TODO
	public function vars(Request $request) {
		return $this->index($request);
	}
	// TODO
	public function engines(Request $request) {
		return $this->index($request);
	}
	// TODO
	public function encodings(Request $request) {
		return $this->index($request);
	}
	// TODO
	public function schemas(Request $request) {
		return $this->index($request);
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
	// TODO
	public function sql(Request $request) {
		return $this->index($request);
	}
}
