<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model {

	private $name;

	public function __construct(string $name) {
		$this->name = $name;
	}

	public function render() {
		return view('include.head').view("page.{$this->name}").view('include.foot');
	}

	public static function new(...$params): self {
		return new self(...$params);
	}
}
