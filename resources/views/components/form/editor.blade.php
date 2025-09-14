@props([
    'name',
    'label' => '',
    'value' => '',
    'required' => false,
    'height' => 200,
    'toolbar' => 'full', // full, basic, minimal
])

<div class="mb-3">
    @if ($label)
        <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
    @endif

    <textarea name="{{ $name }}" id="{{ $name }}_editor" class="form-control ranjit-editor"
        {{ $required ? 'required' : '' }}>{{ old($name, $value) }}</textarea>

<span class="text-danger">
    @error($name)
       {{ $message }}
    @enderror
</span>
</div>

