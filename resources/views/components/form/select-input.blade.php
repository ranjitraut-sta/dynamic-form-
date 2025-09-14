@props([
    'id',
    'name',
    'label' => '',
    'required' => false,
    'value' => '',
    'options' => [],
])
<div class="form-group">
    <x-form.label :for="$id" :required="$required">{{ $label }}</x-form.label>
    <select name="{{ $name }}" id="{{ $id }}" class="form-control">
        <option value="">-- Select --</option>
        @foreach ($options as $key => $option)
            <option value="{{ $key }}" @selected($key == $value)>{{ $option }}</option>
        @endforeach
    </select>

    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
