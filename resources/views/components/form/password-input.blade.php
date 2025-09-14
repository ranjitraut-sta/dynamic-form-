@props([
    'id',
    'name',
    'label' => '',
    'required' => false,
    'value' => '',
    'placeholder' => '',
])
<div class="form-group mb-3">
    <x-form.label :for="$id" :required="$required">{{ $label }}</x-form.label>
    <div class="input-group">
        <input type="password" name="{{ $name }}" id="{{ $id }}"
               class="form-control" placeholder="{{ $placeholder ?? 'Password' }}">
        <button class="btn btn-outline-secondary" type="button"
                onclick="togglePassword('{{ $id }}', 'toggleIcon_{{ $id }}')"
                aria-label="Toggle password visibility">
            <i id="toggleIcon_{{ $id }}" class="fa-solid fa-eye"></i>
        </button>
    </div>
    @error($name)
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
@once
    @push('scripts')
        <script>
            function togglePassword(id, iconId) {
                const input = document.getElementById(id);
                const icon = document.getElementById(iconId);
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        </script>
    @endpush
@endonce

