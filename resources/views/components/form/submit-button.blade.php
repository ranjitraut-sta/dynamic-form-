@props([
    'label' => 'Submit',
    'class' => '', // default empty
])

<div class="form-group">
    <button type="submit" {{ $attributes->merge(['class' => 'amd-btn amd-btn-primary amd-btn-sm mt-2' . $class]) }}>
        {{ $label }}
    </button>
</div>
