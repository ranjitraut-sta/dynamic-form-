<?php

namespace App\View\Components\Table;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Closure;

class TopHeader extends Component
{
    public string $title;
    public ?string $createRoute;
    public ?string $createLabel;
    public ?string $class;
    public bool $column;
    public string $columnLabel;  // Add this

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $title,
        ?string $createRoute = null,
        ?string $createLabel = 'Add New',
        ?string $class = '',
        bool $column = false,
        string $columnLabel = 'Columns'   // Default label
    ) {
        $this->title = $title;
        $this->createRoute = $createRoute;
        $this->createLabel = $createLabel;
        $this->class = $class;
        $this->column = $column;
        $this->columnLabel = $columnLabel;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table.top-header');
    }
}
