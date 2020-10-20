<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class LoginController extends Controller {

    public function index(Request $request) {
		return Page::new('index')->render();
	}

	public function login(Request $request) {
		if (auth()->login($request->all()))
			return redirect()->route('admin');
		return redirect('/')->withErrors([
			'connection' => ',kzlbotfj'
		]);
	}

	public function logout(Request $request) {
		auth()->logout();
		return redirect('/');
	}
}
