<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Page;
use App\Entity\Entity;
use App\View\EntityView;

class EntityController extends Controller {

	public function index(Request $request, string $type = null) {
		$entityView = EntityView::getClass($type);
		if ($entityView)
			$entityView = new $entityView;
		return Page::new('entity_index')->withData([
			'class' => Entity::getClass($type),
			'view' => $entityView,
			'type' => $type,
			'data' => Entity::getClass($type)::list($request->all())
		])->render();
	}

	public function create(Request $request, string $type) {
		if ($request->isMethod('POST')) {
			$entity = Entity::getClass($type)::create($request->all());
			return redirect()->route('index', $type);
		} else {
			$entityView = EntityView::getClass($type);
			if ($entityView)
				$entityView = new $entityView;
			return Page::new('entity_create')->withData([
				'class' => Entity::getClass($type),
				'view' => $entityView,
				'type' => $type,
			])->render();
		}
	}

	// TODO
	public function read(Request $request, string $type, string $id) {
		$EntityClass = Entity::getClass($type);
		$entity = $EntityClass::read($id, $request->all());
		$EntityViewClass = EntityView::getClass($type);
		$view = new $EntityViewClass($entity);
		return Page::new('entity_read')->withData([
			'class' => $EntityClass,
			'view' => $view,
			'entity' => $entity,
			'type' => $type
		])->render();
	}

	public function update(Request $request, string $type, string $id) {
		$entity = Entity::getClass($type)::read($id, $request->all());
		if ($request->isMethod('POST')) {
			$entity->update($request->all());
			$data = ['type' => $type, 'id' => $entity->id()];
			foreach ($request->all() as $key => $value)
				if ($key !== '_token' && !preg_match('/^[A-Z_]+$/', $key))
					$data[$key] = $value;
			return redirect()->action([self::class, 'update'], $data);
		} else {
			$entityView = EntityView::getClass($type);
			if ($entityView)
				$entityView = new $entityView($entity);
			return Page::new('entity_update')->withData([
				'type' => $type,
				'view' => $entityView,
				'entity' => $entity
			])->render();
		}
	}

	public function delete(Request $request, string $type, string $id) {
		$entity = Entity::getClass($type)::read($id, $request->all());
		if ($request->isMethod('POST')) {
			$entity->delete();
			return redirect()->route('index', ['type' => $type]);
		} else {
			return Page::new('entity_delete')->withData([
				'entity' => $entity,
			])->render();
		}
	}

	public function truncate(Request $request, string $type, string $id) {
		$entity = Entity::getClass($type)::read($id, $request->all());
		if ($request->isMethod('POST')) {
			$entity->truncate();
			return redirect()->route('index', ['type' => $type]);
		} else {
			return Page::new('entity_truncate')->withData([
				'entity' => $entity,
			])->render();
		}
	}

	private static function entityView(string $type): string {

	}
}
