<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;
use App\PDOWrapper;
use App\Entity\Entity;

class Sidebar extends Component {

	public function __construct() {}

	public function render() {
		return view('components.sidebar', $this->getData());
	}
	
	private function getData(): array {
		$requestType = request()->type;
		return [
			'links' => [
				[
					'link' => route('admin'),
					'name' => __('admin.overview'),
					'active' => strpos(Route::currentRouteName(), 'admin') === 0,
					'iconClass' => 'fas fa-list fa-fw',
					'visible' => true
				],
				[
					'link' => route('index', [
						'type' => 'user'
					]),
					'name' => __('entity.type.user.index'),
					'active' => $requestType === 'user',
					'iconClass' => 'fas fa-users fa-fw',
					'visible' => auth()->user()->isRoot()
				],
				[
					'link' => route('index', [
						'type' => 'variable'
					]),
					'name' => __('entity.type.variable.index'),
					'active' => $requestType === 'variable',
					'iconClass' => 'fas fa-code fa-fw',
					'visible' => true
				],
				[
					'link' => route('index', [
						'type' => 'engine'
					]),
					'name' => __('entity.type.engine.index'),
					'active' => $requestType === 'engine',
					'iconClass' => 'fas fa-table fa-fw',
					'visible' => true
				],
				[
					'link' => route('index', [
						'type' => 'encoding'
					]),
					'name' => __('entity.type.encoding.index'),
					'active' => $requestType === 'encoding',
					'iconClass' => 'fas fa-spell-check fa-fw',
					'visible' => true
				],
				[
					'link' => route('index', [
						'type' => 'schema'
					]),
					'name' => __('entity.type.encoding.index'),
					'active' => $requestType === 'schema',
					'iconClass' => 'fas fa-database fa-fw',
					'visible' => true
				],
				[
					'link' => route('index', [
						'type' => 'sql'
					]),
					'name' => __('admin.sql'),
					'active' => Route::currentRouteName() === 'admin.sql',
					'iconClass' => 'fas fa-terminal fa-fw',
					'visible' => true
				],
				[
					'link' => route('logout'),
					'name' => __('route.logout'),
					'active' => Route::currentRouteName() === 'route.logout',
					'iconClass' => 'fas fa-sign-out-alt fa-fw',
					'visible' => true
				]
			],
		];
	}

	private function schemasLinks(): array {
		$result = [];
		if ($user = session()->get('user')) {
			foreach ($user->getAccessibleDatabases() as $dbname) {
				$result[] = [
					'link' => route('read', [
						'type' => 'schema',
						'id' => $dbname
					]),
					'name' => $dbname,
					'active' => Route::currentRouteName() === 'admin.schema.read' && request()->name === $dbname,
					'iconClass' => 'fas fa-database fa-fw'
				];
			}
		}
		return $result;
	}
}
