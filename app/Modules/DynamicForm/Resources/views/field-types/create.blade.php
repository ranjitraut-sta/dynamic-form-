@extends('admin.main.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>Create Field Type</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('field-types.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Field Name (Code)</label>
                                    <input type="text" name="name" class="form-control" placeholder="e.g. custom_text" required>
                                    <small class="text-muted">Used in code, no spaces</small>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label>Display Label</label>
                                    <input type="text" name="label" class="form-control" placeholder="e.g. Custom Text Field" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label>Icon Class</label>
                                    <input type="text" name="icon" class="form-control" placeholder="fas fa-text" value="fas fa-square">
                                    <small class="text-muted">FontAwesome icon class</small>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label>Validation Rules</label>
                                    <input type="text" name="validation_rules" class="form-control" placeholder="required,string,max:255">
                                    <small class="text-muted">Comma separated Laravel validation rules</small>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input type="checkbox" name="has_options" class="form-check-input" id="hasOptions">
                                    <label class="form-check-label" for="hasOptions">Has Options (select, radio, checkbox)</label>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input type="checkbox" name="is_active" class="form-check-input" id="isActive" checked>
                                    <label class="form-check-label" for="isActive">Active</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>HTML Template</label>
                                    <textarea name="html_template" class="form-control" rows="10" required placeholder="<input type='text' class='form-control' name='{name}' placeholder='{placeholder}'>"></textarea>
                                    <small class="text-muted">
                                        Available placeholders:<br>
                                        • {name} - Field name<br>
                                        • {placeholder} - Placeholder text<br>
                                        • {required} - Required attribute<br>
                                        • {options} - Options for select/radio/checkbox
                                    </small>
                                </div>
                                
                                <div id="optionsHelp" style="display:none;">
                                    <h6>📝 Options Template Examples:</h6>
                                    <div class="bg-light p-2 mb-2">
                                        <strong>Select:</strong><br>
                                        <code>&lt;option value="{value}"&gt;{label}&lt;/option&gt;</code>
                                    </div>
                                    <div class="bg-light p-2 mb-2">
                                        <strong>Radio:</strong><br>
                                        <code>&lt;input type="radio" name="{name}" value="{value}"&gt; {label}</code>
                                    </div>
                                    <div class="bg-light p-2">
                                        <strong>Checkbox:</strong><br>
                                        <code>&lt;input type="checkbox" name="{name}[]" value="{value}"&gt; {label}</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">💾 Save Field Type</button>
                            <a href="{{ route('field-types.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('hasOptions').addEventListener('change', function() {
    document.getElementById('optionsHelp').style.display = this.checked ? 'block' : 'none';
});
</script>
@endsection