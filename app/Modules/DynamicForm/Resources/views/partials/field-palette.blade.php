<div class="field-palette">
    @foreach($fieldTypes as $field)
    <div class="field-item" draggable="true" data-type="{{ $field['type'] }}" data-config="{{ json_encode($field) }}">
        <i class="{{ $field['icon'] }}"></i> {{ $field['label'] }}
    </div>
    @endforeach
</div>
