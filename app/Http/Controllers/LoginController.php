<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Middleware\Main;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index(Request $request) {
		// config(['database.connections.mysql' => [
		// 	'username' => 'netcat',
		// 	'password' => 'netcat',
		// 	'host' => 'localhost',
		// 	'database' => 'netcat',
		// 	'driver' => 'mysql'
		// ]]);
		
		return view('include.header').view('page.index').view('include.footer');
	}

	public function login(Request $request, Main $mainMiddleware) {
		try {
			$username = $request->input('username');
			$password = $request->input('password');
			$connection = env('DB_CONNECTION', 'mysql');
			$host = env('DB_HOST', 'localhost');
			$port = env('DB_PORT', '3306');
			$pdo = new \PDO("{$connection}:host={$host};port={$port}", $username, $password);
			$dbNames = [];
			foreach ($pdo->query('SHOW DATABASES') as $row)
				$dbNames[] = $row['Database'];
			session()->put('database', [
				'username' => $username,
				'password' => $password,
				'names' => $dbNames,
			]);
			$mainMiddleware->setConnections();
			$user = new User;
			$user->username = $username;
			$user->password = Hash::make($password);
			$user->email = '';
			Auth::login($user);
		} catch (\PDOException $ex) {
			return redirect('/')->withErrors([
				'connection' => true
			]);
		}
		return view('include.header').view('page.home').view('include.footer');
	}
}
