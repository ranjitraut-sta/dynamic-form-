@extends('admin.main.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Field Type: {{ $fieldType->label }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('field-types.update', $fieldType) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Field Name (Code)</label>
                                    <input type="text" name="name" class="form-control" value="{{ $fieldType->name }}" required>
                                    <small class="text-muted">Used in code, no spaces</small>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label>Display Label</label>
                                    <input type="text" name="label" class="form-control" value="{{ $fieldType->label }}" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label>Icon Class</label>
                                    <input type="text" name="icon" class="form-control" value="{{ $fieldType->icon }}">
                                    <small class="text-muted">FontAwesome icon class</small>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label>Validation Rules</label>
                                    <input type="text" name="validation_rules" class="form-control" value="{{ implode(',', $fieldType->validation_rules ?? []) }}">
                                    <small class="text-muted">Comma separated Laravel validation rules</small>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input type="checkbox" name="has_options" class="form-check-input" id="hasOptions" {{ $fieldType->has_options ? 'checked' : '' }}>
                                    <label class="form-check-label" for="hasOptions">Has Options (select, radio, checkbox)</label>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input type="checkbox" name="is_active" class="form-check-input" id="isActive" {{ $fieldType->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label" for="isActive">Active</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>HTML Template</label>
                                    <textarea name="html_template" class="form-control" rows="10" required>{{ $fieldType->html_template }}</textarea>
                                    <small class="text-muted">
                                        Available placeholders:<br>
                                        • {name} - Field name<br>
                                        • {placeholder} - Placeholder text<br>
                                        • {required} - Required attribute<br>
                                        • {options} - Options for select/radio/checkbox
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">💾 Update Field Type</button>
                            <a href="{{ route('field-types.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection