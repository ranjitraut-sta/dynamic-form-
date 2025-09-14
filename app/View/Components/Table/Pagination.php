<?php

namespace App\View\Components\Table;

use Illuminate\View\Component;

class Pagination extends Component
{
    public $records;
    public $length;

    public function __construct($records, $length = false)
    {
        $this->records = $records;
        $this->length = $length;
    }

    public function render()
    {
        return view('components.table.pagination');
    }
}
