@extends('admin.main.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>🎨 Create Custom Field Type</h3>
                    <p class="text-muted mb-0">Create your own custom form field that will appear in the form builder</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('field-types.store') }}" method="POST">
                        @csrf
                        
                        <!-- Quick Templates -->
                        <div class="alert alert-info">
                            <h6>🚀 Quick Start Templates</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="loadTemplate('slider')">🎯 Range Slider</button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-outline-success btn-sm" onclick="loadTemplate('color')">🎨 Color Picker</button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-outline-warning btn-sm" onclick="loadTemplate('rating')">⭐ Star Rating</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label><strong>🏷️ Field Name</strong></label>
                                    <input type="text" name="name" id="fieldName" class="form-control" placeholder="e.g. rating_field" required>
                                    <small class="text-muted">Unique name (letters, numbers, underscore only)</small>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label><strong>📝 Display Label</strong></label>
                                    <input type="text" name="label" id="fieldLabel" class="form-control" placeholder="e.g. Star Rating" required>
                                    <small class="text-muted">What users will see in the form builder</small>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label><strong>🎨 Icon</strong></label>
                                    <div class="input-group">
                                        <input type="text" name="icon" id="fieldIcon" class="form-control" placeholder="fas fa-star" value="fas fa-square">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i id="iconPreview" class="fas fa-square"></i></span>
                                        </div>
                                    </div>
                                    <small class="text-muted">FontAwesome icon class - <a href="https://fontawesome.com/icons" target="_blank">Browse icons</a></small>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input type="checkbox" name="has_options" class="form-check-input" id="hasOptions">
                                    <label class="form-check-label" for="hasOptions">
                                        <strong>📋 Has Options</strong> (for dropdowns, radio buttons, checkboxes)
                                    </label>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input type="checkbox" name="is_active" class="form-check-input" id="isActive" checked>
                                    <label class="form-check-label" for="isActive">
                                        <strong>✅ Active</strong> (show in form builder)
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label><strong>💻 HTML Template</strong></label>
                                    <textarea name="html_template" id="htmlTemplate" class="form-control" rows="8" required placeholder="<input type='text' class='form-control' name='{name}' placeholder='{placeholder}'>"></textarea>
                                    <div class="mt-2">
                                        <small class="text-muted">
                                            <strong>Available placeholders:</strong><br>
                                            🏷️ <code>{name}</code> - Field name<br>
                                            📝 <code>{placeholder}</code> - Placeholder text<br>
                                            ❗ <code>{required}</code> - Required attribute<br>
                                            📋 <code>{options}</code> - Options for select/radio/checkbox
                                        </small>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label><strong>🔍 Validation Rules (Optional)</strong></label>
                                    <input type="text" name="validation_rules" id="validationRules" class="form-control" placeholder="required,string,max:255">
                                    <small class="text-muted">Laravel validation rules (comma separated)</small>
                                </div>
                                
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6>🔥 Live Preview</h6>
                                        <div id="fieldPreview" class="border p-3 bg-white rounded">
                                            <em class="text-muted">Preview will appear here...</em>
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="optionsHelp" style="display:none;" class="mt-3">
                                    <div class="alert alert-warning">
                                        <h6>📝 Options Template Examples:</h6>
                                        <div class="mb-2">
                                            <strong>Select:</strong><br>
                                            <code>&lt;option value="{value}"&gt;{label}&lt;/option&gt;</code>
                                        </div>
                                        <div class="mb-2">
                                            <strong>Radio:</strong><br>
                                            <code>&lt;input type="radio" name="{name}" value="{value}"&gt; {label}</code>
                                        </div>
                                        <div>
                                            <strong>Checkbox:</strong><br>
                                            <code>&lt;input type="checkbox" name="{name}[]" value="{value}"&gt; {label}</code>
                                        </div>
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
// Templates
const templates = {
    slider: {
        name: 'range_slider',
        label: 'Range Slider',
        icon: 'fas fa-sliders-h',
        html: '<input type="range" class="form-range" name="{name}" min="0" max="100" {required}>',
        validation: 'numeric,min:0,max:100'
    },
    color: {
        name: 'color_picker',
        label: 'Color Picker',
        icon: 'fas fa-palette',
        html: '<input type="color" class="form-control" name="{name}" {required}>',
        validation: 'string'
    },
    rating: {
        name: 'star_rating',
        label: 'Star Rating',
        icon: 'fas fa-star',
        html: '<div class="rating"><input type="radio" name="{name}" value="1">★<input type="radio" name="{name}" value="2">★★<input type="radio" name="{name}" value="3">★★★<input type="radio" name="{name}" value="4">★★★★<input type="radio" name="{name}" value="5">★★★★★</div>',
        validation: 'numeric,min:1,max:5'
    }
};

function loadTemplate(type) {
    const template = templates[type];
    document.getElementById('fieldName').value = template.name;
    document.getElementById('fieldLabel').value = template.label;
    document.getElementById('fieldIcon').value = template.icon;
    document.getElementById('htmlTemplate').value = template.html;
    document.getElementById('validationRules').value = template.validation;
    updateIconPreview();
    updatePreview();
}

// Icon preview
document.getElementById('fieldIcon').addEventListener('input', updateIconPreview);

function updateIconPreview() {
    const icon = document.getElementById('fieldIcon').value;
    document.getElementById('iconPreview').className = icon || 'fas fa-square';
}

// Live preview
document.getElementById('htmlTemplate').addEventListener('input', updatePreview);
document.getElementById('fieldLabel').addEventListener('input', updatePreview);

function updatePreview() {
    const html = document.getElementById('htmlTemplate').value;
    const label = document.getElementById('fieldLabel').value || 'Field Label';
    
    let preview = html
        .replace(/{name}/g, 'preview_field')
        .replace(/{placeholder}/g, 'Enter ' + label.toLowerCase())
        .replace(/{required}/g, '')
        .replace(/{options}/g, '<option>Option 1</option><option>Option 2</option>');
    
    document.getElementById('fieldPreview').innerHTML = `
        <label><strong>${label}</strong></label>
        ${preview}
    `;
}

// Options help
document.getElementById('hasOptions').addEventListener('change', function() {
    document.getElementById('optionsHelp').style.display = this.checked ? 'block' : 'none';
});

// Initialize
updateIconPreview();
</script>
@endsection