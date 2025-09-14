<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

class SidebarMenu extends Component
{
    public $items;

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function render()
    {
        return view('components.ui.sidebar-menu');
    }
}
