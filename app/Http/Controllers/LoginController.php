<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Middleware\Main;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller {

    public function index(Request $request) {
		return view('include.head').view('page.index').view('include.foot');
	}

	public function login(Request $request, Main $mainMiddleware) {
		$credentials = $request->only('username', 'password');
		if (auth()->login($credentials))
			return view('include.head').view('page.home').view('include.foot');
		return redirect('/');
	}

	public function logout(Request $request) {
		auth()->logout();
		return redirect('/');
	}
}
