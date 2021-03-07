<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Page;

class EntityController extends Controller {

	// public function create(Request $request, string $type, ?string $id = null) {
	// 	call_user_func([self::entityClass($type), 'create'], $request->all());
	// 	return redirect()->route('admin.index', $type);
	// }

	// public function delete(Request $request, string $type, ?string $id = null) {
	// 	Table::read(self::dataFromArgs($schema, $table))->delete();
	// 	return redirect()->route('admin.schema.table', ['id' => $schema]);
	// }

	public function read(Request $request, string $type, ?string $id = null) {
		$entity = call_user_func([self::entityClass($type), 'read'], $request->all());
		if (!$entity)
			return abort(404);
		return Page::new('entity_read')->withData([
			'name' => $id,
			'login' => $user->getLogin(),
			'limits' => $user->getLimits(),
			'privileges' => $user->getPrivileges()
		])->render();
	}

	public function update(Request $request, string $type, ?string $id = null) {
		$oTable = Table::read(self::dataFromArgs($schema, $table));
		if (!$oTable)
			return abort(404);
		$oTable->update($request->all());
		return redirect()->action([self::class, 'read'], ['id' => $oTable->TABLE_SCHEMA, 'name' => $oTable->TABLE_NAME]);
	}

	private static function entityClass(string $type): string {
		return '\\App\\Models\\'.ucfirst($type);
	}
}
