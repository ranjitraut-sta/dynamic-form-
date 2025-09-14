@props([
    'id',
    'name',
    'label' => '',
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
])
<div class="form-group">
    <x-form.label :for="$id" :required="$required">{{ $label }}</x-form.label>
    <input
        type="{{ $type }}"
        id="{{ $id }}"
        name="{{ $name }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        class="form-control @error($name) is-invalid @enderror"
        @if($required) @endif
    >
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
