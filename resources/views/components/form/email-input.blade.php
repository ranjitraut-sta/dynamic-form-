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
    <input
        type="email"
        id="{{ $id }}"
        name="{{ $name }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        class="form-control @error($name) is-invalid @enderror"
        @if($required) required @endif
    >
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
