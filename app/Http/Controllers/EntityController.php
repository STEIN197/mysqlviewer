<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Page;

class EntityController extends Controller {

	public function index(Request $request, string $type = null) {
		$entityList = call_user_func([self::entityClass($type), 'list'], $request->all());
		return Page::new('entity_index')->withData([
			'class' => self::entityClass($type),
			'type' => $type,
			'data' => $entityList
		])->render();
	}

	public function create(Request $request, string $type) {
		$entity = call_user_func([self::entityClass($type), 'create'], $request->all());
		return redirect()->route('index', $type);
	}

	public function read(Request $request, string $type, string $id) {
		$entity = call_user_func([self::entityClass($type), 'read'], $id, $request->all());
		if (!$entity)
			return abort(404);
		return Page::new('entity_read')->withData([
			'data' => $entity->data()
		])->render();
	}

	public function update(Request $request, string $type, string $id) {
		$entity = call_user_func([self::entityClass($type), 'read'], $id, $request->all());
		if (!$entity)
			return abort(404);
		$entity->update($request->all());
		return redirect()->action([self::class, 'read'], ['type' => $type, 'id' => $id]);
	}

	public function delete(Request $request, string $type, string $id) {
		$entity = call_user_func([self::entityClass($type), 'read'], $id, $request->all());
		if (!$entity)
			return abort(404);
		$entity->delete();
		return redirect()->route('index', ['type' => $type, 'id' => $id]);
	}

	private static function entityClass(string $type): string {
		return '\\App\\Models\\'.ucfirst($type);
	}
}
