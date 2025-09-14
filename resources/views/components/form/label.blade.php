@props([
    'for',
    'required' => false,
    'class' => '',
])

<label for="{{ $for }}" class="form-label {{ $class }}">
    {{ $slot }}
    @if ($required)
        <span class="text-danger">*</span>
    @endif
</label>
