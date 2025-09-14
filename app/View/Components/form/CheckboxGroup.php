<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class CheckboxGroup extends Component
{
    public $name;
    public $label;
    public $options;
    public $selected;
    public $required;
    public $inline;

    /**
     * Create a new component instance.
     *
     * @param string $name
     * @param string $label
     * @param array $options
     * @param array|string $selected
     * @param bool $required
     * @param bool $inline
     */
    public function __construct(
        $name,
        $label = '',
        $options = [],
        $selected = [],
        $required = false,
        $inline = false
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->options = $options;

        // normalize selected to array and support old() values
        $this->selected = old($name, (array) $selected);

        $this->required = $required;
        $this->inline = $inline;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.form.checkbox-group');
    }
}
