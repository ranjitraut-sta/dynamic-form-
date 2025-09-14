<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class MultiSelect extends Component
{
    public $name;
    public $label;
    public $options;
    public $selected;
    public $required;
    public $placeholder;
    public $searchable;

    /**
     * Create a new component instance.
     *
     * @param string $name
     * @param string $label
     * @param array $options
     * @param array|string $selected
     * @param bool $required
     * @param string $placeholder
     * @param bool $searchable
     */
    public function __construct(
        $name,
        $label = '',
        $options = [],
        $selected = [],
        $required = false,
        $placeholder = 'Select options...',
        $searchable = true
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->options = $options;
        $this->selected = old($name, (array) $selected); // old() fallback
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->searchable = $searchable;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.form.multi-select');
    }
}
