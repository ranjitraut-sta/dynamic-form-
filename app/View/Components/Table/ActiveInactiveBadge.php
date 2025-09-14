<?php

namespace App\View\Components\Table;

use Illuminate\View\Component;

class ActiveInactiveBadge extends Component
{
    public string|null $status;
    public string|null $label;

    public function __construct(string|null $status = null, string|null $label = null)
    {
        $this->status = $status;
        $this->label = $label;
    }

    public function normalizedStatus(): string
    {
        return match (strtolower((string) $this->status)) {
            '1', 'true', 'active' => 'active',
            '0', 'false', 'inactive', '2' => 'inactive',
            default => 'unknown',
        };
    }


    public function color(): string
    {
        return match ($this->normalizedStatus()) {
            'active' => 'success',
            'inactive' => 'secondary',
            default => 'dark',
        };
    }

    public function displayLabel(): string
    {
        return $this->label ?? match ($this->normalizedStatus()) {
            'active' => 'Active',
            'inactive' => 'Inactive',
            default => 'Unknown',
        };
    }



    public function render()
    {
        return view('components.table.active-inactive-badge');
    }
}
