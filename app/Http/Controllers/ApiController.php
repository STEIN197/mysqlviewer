<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Locale;

class ApiController extends Controller
{
    public function index(Request $request) {
		if ($request->input('locale') && Locale::exists($request->input('locale')))
			return $this->setLocale($request->input('locale'));
	}

	public function setLocale(string $locale) {
		session()->put('locale', $locale);
		app()->setLocale($locale);
		return response()->json(session()->all());
	}
}
