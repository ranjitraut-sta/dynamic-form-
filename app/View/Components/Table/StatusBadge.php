<?php

namespace App\View\Components\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatusBadge extends Component
{
    public $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function render()
    {
        return view('components.table.status-badge');
    }
}


