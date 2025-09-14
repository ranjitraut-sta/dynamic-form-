<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class DateInput extends Component
{
    public $id;
    public $name;
    public $label;
    public $value;
    public $placeholder;
    public $required;

    public function __construct($name, $label, $value = '', $placeholder = '', $required = false, $id = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = old($name, $value);
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->id = $id ?? $name; // fallback: if id not provided, use name
    }

    public function render()
    {
        return view('components.form.date-input');
    }
}
