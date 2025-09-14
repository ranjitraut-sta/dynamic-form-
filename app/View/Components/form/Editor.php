<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Editor extends Component
{
    public $name;
    public $label;
    public $value;
    public $required;
    public $height;
    public $toolbar;

    public function __construct(
        $name,
        $label = '',
        $value = '',
        $required = false,
        $height = 200,
        $toolbar = 'full'
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->value = old($name, $value);
        $this->required = $required;
        $this->height = $height;
        $this->toolbar = $toolbar;
    }

    public function render()
    {
        return view('components.form.editor');
    }
}
