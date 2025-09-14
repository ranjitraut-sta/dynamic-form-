<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class EmailInput extends Component
{
    public $id, $name, $label, $value, $placeholder, $required;

    public function __construct(
        $name,
        $label,
        $value = '',
        $placeholder = '',
        $required = false,
        $id = null
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->value = old($name, $value);
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->id = $id ?? $name;
    }

    public function render()
    {
        return view('components.form.email-input');
    }
}
