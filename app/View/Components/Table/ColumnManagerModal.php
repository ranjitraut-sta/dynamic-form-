<?php

namespace App\View\Components\Table;

use Illuminate\View\Component;

class ColumnManagerModal extends Component
{
    public string $title;

    public function __construct(string $title = 'Manage Columns')
    {
        $this->title = $title;
    }

    public function render()
    {
        return view('components.table.column-manager-modal');
    }
}
