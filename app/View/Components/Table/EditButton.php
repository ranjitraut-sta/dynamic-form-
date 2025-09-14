<?php

namespace App\View\Components\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EditButton extends Component
{
    /**
     * Create a new component instance.
     */
    public $route;
    public $id;

    public function __construct($route, $id)
    {
        $this->route = $route;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table.edit-button');
    }
}
