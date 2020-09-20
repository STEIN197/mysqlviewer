<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormField extends Component
{

	public ?string $type;
	public ?string $placeholder;
	public ?string $name;
	public ?array $items;
	public ?string $activeItem;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $name, $placeholder, $items = null, $activeItem = null)
    {
		$this->type = $type;
		$this->placeholder = $placeholder;
		$this->name = $name;
		$this->items = $items;
		$this->activeItem = $activeItem;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form-field');
    }
}
