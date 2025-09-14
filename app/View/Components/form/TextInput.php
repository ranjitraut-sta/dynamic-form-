<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TextInput extends Component
{
    public $id, $name, $label, $value, $placeholder, $required, $type;

    public function __construct(
        $name,
        $label,
        $type = 'text',
        $value = '',
        $placeholder = '',
        $required = false,
        $id = null // 👈 optional id
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->value = old($name, $value);
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->id = $id ?? $name; // 👈 fallback: id = name
    }

    public function render(): View|Closure|string
    {
        return view('components.form.text-input');
    }
}
