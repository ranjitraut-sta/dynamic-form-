@props(['name', 'label', 'id' => $name, 'value' => old($name, session($name)), 'required' => false, 'fullpath' => null])

@php
    $errorClass = $errors->has($name) ? 'is-invalid' : '';

    // Determine current file path
    $tempImage = session($name . '_temp_path') ?? null;
    $imagePath = '';

    if (!empty($tempImage)) {
        $imagePath = asset("storage/{$tempImage}");
    } elseif (!empty($fullpath) && !empty($value)) {
        $imagePath = asset("storage/{$fullpath}/{$value}");
    } elseif (!empty($value) && str_contains($value, '/')) {
        $imagePath = asset("storage/{$value}");
    } elseif (!empty($value)) {
        $imagePath = asset("storage/uploads/{$value}");
    }

    // Check if current file is PDF
    $isPdf = $imagePath && strtolower(pathinfo($imagePath, PATHINFO_EXTENSION)) === 'pdf';
@endphp

<x-form.label :for="$id" :required="$required">{{ $label }}</x-form.label>

<div class="file-upload-wrapper"
    style="width: 200px; height: 200px; position: relative; border: 1px dashed #ccc; display: flex; align-items: center; justify-content: center; cursor: pointer;">
    <div class="upload-placeholder" style="{{ $imagePath ? 'display: none;' : '' }}">Click to upload</div>

    <input type="file" name="{{ $name }}" id="{{ $id }}" class="file-input {{ $errorClass }}"
        accept="image/*,application/pdf"
        style="position: absolute; top:0; left:0; width: 100%; height: 100%; opacity: 0; cursor: pointer;"
        data-preview-class="preview-in-field-{{ $id }}">

    @if ($isPdf)
        <a href="{{ $imagePath }}" target="_blank" class="pdf-preview-link"
            style="display: block; width: 100%; height: 100%; text-align: center; padding-top: 80px; font-weight: bold; text-decoration: none; color: #555; background: #f7f7f7;">
            📄 Upload New Pdf
        </a>
    @elseif ($imagePath)
        <img src="{{ $imagePath }}" class="preview-img preview-in-field-{{ $id }}"
            style="max-width: 100%; max-height: 100%; display: block;">
    @else
        <img src="#" class="preview-img preview-in-field-{{ $id }}"
            style="display: none; max-width: 100%; max-height: 100%;">
    @endif

    <button type="button" class="delete-btn"
        style="{{ $imagePath ? '' : 'display: none;' }} position: absolute; top: 5px; right: 5px; background: #ff4d4f; border: none; color: white; font-weight: bold; font-size: 18px; line-height: 1; width: 25px; height: 25px; border-radius: 50%; cursor: pointer;">
        ×
    </button>
</div>
@if ($isPdf)
    <a href="{{ $imagePath }}" target="_blank">Old PDF file</a>
@endif

@error($name)
    <div class="invalid-feedback d-block">
        {{ $message }}
    </div>
@enderror
