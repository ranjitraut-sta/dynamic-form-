<?php

namespace App\View\Components\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ActionButton extends Component
{
    public $route;
    public $id;
    public $class;
    public $icon;
    public $title;

    /**
     * Create a new component instance.
     */
    public function __construct($route, $id, $class = 'btn btn-sm btn-default', $icon = 'fa fa-edit', $title = 'Edit')
    {
        $this->route = $route;
        $this->id = $id;
        $this->class = $class;
        $this->icon = $icon;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table.action-button');
    }
}
