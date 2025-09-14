<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectInput extends Component
{
    public $id, $name, $label, $options, $value, $required;

    public function __construct(
        $name,
        $label,
        $options = [],
        $value = '',
        $required = false,
        $id = null // 👈 optional id
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->options = $options;
        $this->value = old($name, $value);
        $this->required = $required;
        $this->id = $id ?? $name; // 👈 fallback id = name
    }

    public function render(): View|Closure|string
    {
        return view('components.form.select-input');
    }
}
