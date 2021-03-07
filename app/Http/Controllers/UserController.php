<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Page;
use App\Models\User;

class UserController extends Controller {

	public function index(Request $request) {
		return Page::new('user_index')->withData([
			'variables' => DB::select('SELECT * FROM mysql.user')
		])->render();
	}

	public function read(Request $request, string $id) {
		$user = User::read(self::dataFromName($id));
		if (!$user)
			return abort(404);
		return Page::new('user_read')->withData([
			'name' => $id,
			'login' => $user->getLogin(),
			'limits' => $user->getLimits(),
			'privileges' => $user->getPrivileges()
		])->render();
	}

	public function update(Request $request, string $id) {
		$user = User::read(self::dataFromName($id));
		if (!$user)
			return abort(404);
		$user->update($request->all());
		return redirect()->action([UserController::class, 'read'], ['id' => (string) $user]);
	}

	public function new(Request $request) {
		return Page::new('user_new')->withData([
			'columns' => [
				'Host', 'User', 'Password'
			]
		])->render();
	}
	
	public function create(Request $request) {
		User::create($request->all());
		return redirect()->route('admin.user.index');
	}

	public static function delete(string $id) {
		User::read(self::dataFromName($id))->delete();
		return back();
	}

	private static function dataFromName(string $id): array {
		[$login, $host] = explode('@', $id);
		return [
			'User' => $login,
			'Host' => $host
		];
	}
}
