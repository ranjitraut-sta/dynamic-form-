<?php

namespace App\View\Components\form;

use Illuminate\View\Component;

class FileUpload extends Component
{
    public $id;
    public $name;
    public $label;
    public $value;
    public $required;

    public function __construct($name, $label, $id = null, $value = null, $required = false)
    {
        $this->name = $name;
        $this->label = $label;
        $this->id = $id ?? $name;
        $this->value = old($name, session($name)) ?? $value;
        $this->required = $required;
    }

    public function render()
    {
        return view('components.form.file-upload');
    }
}
