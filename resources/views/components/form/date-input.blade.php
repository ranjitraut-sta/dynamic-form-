@props([
    'id',
    'name',
    'label' => '',
    'required' => false,
    'value' => '',
    'placeholder' => '',
])
<div class="form-group">
    <x-form.label :for="$id" :required="$required">{{ $label }}</x-form.label>
    <input type="date" name="{{ $name }}" id="{{ $id }}" value="{{ $value }}"
        placeholder="{{ $placeholder }}" class="form-control" @if($required) required @endif>

    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
