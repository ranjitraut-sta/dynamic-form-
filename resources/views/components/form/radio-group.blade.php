@props(['name', 'label' => '', 'options' => [], 'selected' => '', 'required' => false, 'inline' => false])

<div class="mb-3">
    @if ($label)
        <label class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
    @endif

    <div class="{{ $inline ? 'd-flex flex-wrap gap-3' : '' }}">
        @foreach ($options as $value => $text)
            <div class="form-check {{ $inline ? '' : 'mb-2' }}">
                <input class="form-check-input" type="radio" name="{{ $name }}" value="{{ $value }}"
                    id="{{ $name }}_{{ $value }}" {{ $selected == $value ? 'checked' : '' }}
                    {{ $required ? 'required' : '' }}>
                <label class="form-check-label" for="{{ $name }}_{{ $value }}">
                    {{ $text }}
                </label>
            </div>
        @endforeach
    </div>

    @error($name)
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>
