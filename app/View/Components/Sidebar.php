<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

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
					'active' => Route::currentRouteName() === 'admin.schema'
				];
			}
		}
		return [
			'links' => [
				[
					'link' => route('admin'),
					'name' => __('admin.overview'),
					'active' => strpos(Route::currentRouteName(), 'admin') === 0,
					'items' => [
						[
							'link' => route('admin.users'),
							'name' => __('admin.users'),
							'active' => Route::currentRouteName() === 'admin.users',
						],
						[
							'link' => route('admin.vars'),
							'name' => __('admin.variables'),
							'active' => Route::currentRouteName() === 'admin.vars',
						],
						[
							'link' => route('admin.engines'),
							'name' => __('admin.engines'),
							'active' => Route::currentRouteName() === 'admin.engines',
						],
						[
							'link' => route('admin.encodings'),
							'name' => __('admin.encodings'),
							'active' => Route::currentRouteName() === 'admin.encodings',
						],
					]
				],
				[
					'link' => route('admin.schemas'),
					'name' => __('admin.schemas'),
					'active' => Route::currentRouteName() === 'admin.schemas',
					'items' => $schemasLinks
				],
				[
					'link' => route('admin.sql'),
					'name' => __('admin.sql'),
					'active' => Route::currentRouteName() === 'admin.sql',
				],
				[
					'link' => route('logout'),
					'name' => __('route.logout'),
					'active' => Route::currentRouteName() === 'route.logout',
				]
			],
		];
	}
}
