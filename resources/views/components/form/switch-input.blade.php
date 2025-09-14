@props([
    'name',
    'label' => '',
    'checked' => false,
    'value' => '1',
    'size' => 'normal', // normal, small, large
])

@php
    $sizeClass = match ($size) {
        'small' => 'form-switch-sm',
        'large' => 'form-switch-lg',
        default => '',
    };
@endphp

<div class="mb-3">
    <div class="form-check form-switch {{ $sizeClass }}">
        <input class="form-check-input" type="checkbox" role="switch" name="{{ $name }}" value="{{ $value }}"
            id="{{ $name }}_switch" {{ $checked ? 'checked' : '' }} {{ $attributes }}>
        @if ($label)
            <label class="form-check-label" for="{{ $name }}_switch">
                {{ $label }}
            </label>
        @endif
    </div>

    @error($name)
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<style>
    .form-switch-sm .form-check-input {
        width: 1.5em;
        height: 0.75em;
    }

    .form-switch-lg .form-check-input {
        width: 3em;
        height: 1.5em;
    }
</style>

