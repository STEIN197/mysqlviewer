<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormField extends Component {

	public $type;
	public $name;
	public $placeholder;
	public $default;
	public $class;
	public $required;
	public $items;
	public $activeItem;
	
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $name, $placeholder, $default = '', $class = '', $required = false, $items = null, $activeItem = null)
    {
		$this->type = strtolower($type);
		$this->name = $name;
		$this->placeholder = $placeholder;
		$this->default = $default;
		$this->class = $class;
		$this->required = $required;
		$this->items = $items;
		$this->activeItem = $activeItem;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view('components.form-field');
    }
}
