<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class SubmitButton extends Component
{
    public string $label;
    public string $class;

    public function __construct(string $label = 'Submit', string $class = 'btn btn-primary btn-sm')
    {
        $this->label = $label;
        $this->class = $class;
    }

    public function render()
    {
        return view('components.form.submit-button');
    }
}
