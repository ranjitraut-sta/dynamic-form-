@props([
    'name',
    'label' => '',
    'options' => [],
    'selected' => [],
    'required' => false,
    'placeholder' => 'Select options...',
    'searchable' => true,
])

<div class="mb-3">
    @if ($label)
        <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
    @endif

    <div class="multi-select-wrapper" data-name="{{ $name }}">
        <div class="multi-select-display form-control" id="{{ $name }}_display">
            <div class="selected-items"></div>
            <input type="text" class="search-input" placeholder="{{ $placeholder }}"
                {{ !$searchable ? 'readonly' : '' }}>
            <i class="fas fa-chevron-down dropdown-arrow"></i>
        </div>

        <div class="multi-select-dropdown">
            @if ($searchable)
                <div class="search-box p-2">
                    <input type="text" class="form-control form-control-sm" placeholder="Search...">
                </div>
            @endif
            <div class="options-list">
                @foreach ($options as $value => $text)
                    <div class="option-item" data-value="{{ $value }}">
                        <input type="checkbox" class="form-check-input me-2"
                            {{ in_array($value, (array) $selected) ? 'checked' : '' }}>
                        <span>{{ $text }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Hidden inputs for form submission -->
        <div class="hidden-inputs">
            @foreach ((array) $selected as $val)
                <input type="hidden" name="{{ $name }}[]" value="{{ $val }}">
            @endforeach
        </div>
    </div>

    @error($name)
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<style>
    .multi-select-wrapper {
        position: relative;
    }

    .multi-select-display {
        display: flex;
        align-items: center;
        min-height: 38px;
        cursor: pointer;
        position: relative;
    }

    .selected-items {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        flex: 1;
    }

    .selected-item {
        background: #007bff;
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .selected-item .remove {
        cursor: pointer;
        font-weight: bold;
    }

    .search-input {
        border: none;
        outline: none;
        flex: 1;
        min-width: 100px;
    }

    .dropdown-arrow {
        margin-left: auto;
        transition: transform 0.2s;
    }

    .multi-select-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
    }

    .option-item {
        padding: 8px 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
    }

    .option-item:hover {
        background: #f8f9fa;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.multi-select-wrapper').forEach(wrapper => {
            const display = wrapper.querySelector('.multi-select-display');
            const dropdown = wrapper.querySelector('.multi-select-dropdown');
            const selectedItems = wrapper.querySelector('.selected-items');
            const hiddenInputs = wrapper.querySelector('.hidden-inputs');
            const searchInput = wrapper.querySelector('.search-input');
            const arrow = wrapper.querySelector('.dropdown-arrow');

            // --- INITIALIZE default selected items ---
            wrapper.querySelectorAll('.option-item input:checked').forEach(checkbox => {
                const option = checkbox.closest('.option-item');
                const value = option.dataset.value;
                const text = option.querySelector('span').textContent;
                addSelectedItem(value, text); // chip देखाउने
            });
            updateHiddenInputs();

            // Toggle dropdown
            display.addEventListener('click', () => {
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                arrow.style.transform = dropdown.style.display === 'block' ? 'rotate(180deg)' :
                    'rotate(0deg)';
            });

            // Handle option selection
            wrapper.querySelectorAll('.option-item').forEach(option => {
                option.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const checkbox = option.querySelector('input[type="checkbox"]');
                    const value = option.dataset.value;
                    const text = option.querySelector('span').textContent;

                    checkbox.checked = !checkbox.checked;

                    if (checkbox.checked) {
                        addSelectedItem(value, text);
                    } else {
                        removeSelectedItem(value);
                    }

                    updateHiddenInputs();
                });
            });

            function addSelectedItem(value, text) {
                // already added? skip
                if (selectedItems.querySelector(`[data-value="${value}"]`)) return;

                const item = document.createElement('div');
                item.className = 'selected-item';
                item.dataset.value = value;
                item.innerHTML = `<span>${text}</span><span class="remove">×</span>`;

                item.querySelector('.remove').addEventListener('click', (e) => {
                    e.stopPropagation();
                    removeSelectedItem(value);
                    updateHiddenInputs();
                });

                selectedItems.appendChild(item);
            }

            function removeSelectedItem(value) {
                const item = selectedItems.querySelector(`[data-value="${value}"]`);
                if (item) item.remove();

                const checkbox = wrapper.querySelector(`.option-item[data-value="${value}"] input`);
                if (checkbox) checkbox.checked = false;
            }

            function updateHiddenInputs() {
                hiddenInputs.innerHTML = '';
                selectedItems.querySelectorAll('.selected-item').forEach(item => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = wrapper.dataset.name + '[]';
                    input.value = item.dataset.value;
                    hiddenInputs.appendChild(input);
                });
            }

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!wrapper.contains(e.target)) {
                    dropdown.style.display = 'none';
                    arrow.style.transform = 'rotate(0deg)';
                }
            });
        });
    });
</script>
