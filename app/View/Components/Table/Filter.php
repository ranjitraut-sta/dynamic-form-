<?php

namespace App\View\Components\Table;

use Illuminate\View\Component;

class Filter extends Component
{
    public string $action;
    public ?string $placeholder;
    public bool $paginate;
    public bool $search;

    public function __construct(
        string $action,
        ?string $placeholder = null,
        bool $paginate = true,
        bool $search = true
    ) {
        $this->action = $action;
        $this->placeholder = $placeholder;
        $this->paginate = $paginate;
        $this->search = $search;
    }

    public function render()
    {
        return view('components.table.filter');
    }
}
