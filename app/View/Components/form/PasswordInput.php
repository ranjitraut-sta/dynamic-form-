<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PasswordInput extends Component
{
    public $id, $name, $label, $placeholder, $required;

    public function __construct(
        string $name,
        string $label,
        string $placeholder = '',
        bool $required = false,
        string $id = null
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->id = $id ?? $name; // fallback if ID not passed
    }

    public function render(): View|Closure|string
    {
        return view('components.form.password-input');
    }
}
