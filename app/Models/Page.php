<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model {

	private $name;
	private $data = [null];

	public function __construct(string $name) {
		$this->name = $name;
	}

	public function withData(...$params): self {
		$this->data = $params;
		return $this;
	}

	public function render() {
		return view('include.head').view("page.{$this->name}")->with(...$this->data).view('include.foot');
	}

	public static function new(...$params): self {
		return new self(...$params);
	}
}
