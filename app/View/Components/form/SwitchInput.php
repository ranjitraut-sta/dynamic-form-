<?php

namespace App\View\Components\Form;
use Illuminate\View\Component;

class SwitchInput extends Component
{
    public $name;
    public $label;
    public $checked;
    public $value;
    public $size;

    /**
     * Create a new component instance.
     *
     * @param string $name
     * @param string $label
     * @param bool $checked
     * @param string $value
     * @param string $size
     */
    public function __construct(
        $name,
        $label = '',
        $checked = false,
        $value = '1',
        $size = 'normal'
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->checked = $checked;
        $this->value = $value;
        $this->size = $size;
    }

    /**
     * Get the size class for the switch.
     */
    public function sizeClass(): string
    {
        return match ($this->size) {
            'small' => 'form-switch-sm',
            'large' => 'form-switch-lg',
            default => '',
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.form.switch-input');
    }
}
