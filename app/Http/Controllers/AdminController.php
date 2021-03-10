<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Page;

class AdminController extends Controller {

	public function index(Request $request) {
		return Page::new('admin')->render();
	}
}
