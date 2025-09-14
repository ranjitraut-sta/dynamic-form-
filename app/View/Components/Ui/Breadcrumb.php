<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public string $title;
    public array $items;
    public string $extraClass;

    public function __construct(string $title, array $items = [], string $extraClass = '')
    {
        $this->title = $title;
        $this->items = $items;
        $this->extraClass = $extraClass;
    }

    public function render()
    {
        return view('components.ui.breadcrumb');
    }
}
