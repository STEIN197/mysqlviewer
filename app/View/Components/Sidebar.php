<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;
use App\PDOWrapper;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view('components.sidebar', $this->getData());
	}
	
	private function getData(): array {
		$schemasLinks = [];
		if ($user = session()->get('user')) {
			foreach ($user->getAccessibleDatabases() as $dbname) {
				$schemasLinks[] = [
					'link' => route('admin.schema', [
						'name' => $dbname
					]),
					'name' => $dbname,
					'active' => Route::currentRouteName() === 'admin.schema',
					'iconClass' => 'fas fa-database fa-fw'
				];
			}
		}
		$overviewLinks = [
			[
				'link' => route('admin.vars'),
				'name' => __('admin.variables'),
				'active' => Route::currentRouteName() === 'admin.vars',
				'iconClass' => 'fas fa-code fa-fw'
			],
			[
				'link' => route('admin.engines'),
				'name' => __('admin.engines'),
				'active' => Route::currentRouteName() === 'admin.engines',
				'iconClass' => 'fas fa-table fa-fw'
			],
			[
				'link' => route('admin.encodings'),
				'name' => __('admin.encodings'),
				'active' => Route::currentRouteName() === 'admin.encodings',
				'iconClass' => 'fas fa-spell-check fa-fw'
			],
		];
		if (auth()->user()->isRoot())
			array_unshift($overviewLinks, [
				'link' => route('admin.users'),
				'name' => __('admin.users'),
				'active' => Route::currentRouteName() === 'admin.users',
				'iconClass' => 'fas fa-users fa-fw'
			]);
		return [
			'links' => [
				[
					'link' => route('admin'),
					'name' => __('admin.overview'),
					'active' => strpos(Route::currentRouteName(), 'admin') === 0,
					'iconClass' => 'fas fa-list fa-fw',
					'items' => $overviewLinks
				],
				[
					'link' => route('admin.schemas'),
					'name' => __('admin.schemas'),
					'active' => Route::currentRouteName() === 'admin.schemas',
					'iconClass' => 'fas fa-database fa-fw',
					'expands' => true,
					'items' => $schemasLinks,
				],
				[
					'link' => route('admin.sql'),
					'name' => __('admin.sql'),
					'active' => Route::currentRouteName() === 'admin.sql',
					'iconClass' => 'fas fa-terminal fa-fw'
				],
				[
					'link' => route('logout'),
					'name' => __('route.logout'),
					'active' => Route::currentRouteName() === 'route.logout',
					'iconClass' => 'fas fa-sign-out-alt fa-fw'
				]
			],
		];
	}
}
