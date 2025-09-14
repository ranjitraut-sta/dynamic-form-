@extends('admin.main.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Form: {{ $form->title }}</h3>
                </div>
                <div class="card-body">
                    <form id="formBuilder">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Form Title</label>
                                    <input type="text" class="form-control" id="formTitle" value="{{ $form->title }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" id="formDescription" rows="3">{{ $form->description }}</textarea>
                                </div>

                                <!-- Form Builder Area -->
                                <div class="form-builder-area border p-3 mb-3 drop-zone" style="min-height: 400px;" id="formFields">
                                    @if(empty($form->fields))
                                        <h5 class="text-muted">Drag fields here to build your form</h5>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-success">Update Form</button>
                                <a href="{{ route('forms.show', $form) }}" class="btn btn-secondary">Cancel</a>
                            </div>

                            <div class="col-md-4">
                                <h5>Available Fields</h5>
                                <div class="field-palette">
                                    <div class="field-item" draggable="true" data-type="text">
                                        📝 Text Input
                                    </div>
                                    <div class="field-item" draggable="true" data-type="email">
                                        📧 Email
                                    </div>
                                    <div class="field-item" draggable="true" data-type="tel">
                                        📞 Phone
                                    </div>
                                    <div class="field-item" draggable="true" data-type="number">
                                        🔢 Number
                                    </div>
                                    <div class="field-item" draggable="true" data-type="textarea">
                                        📄 Textarea
                                    </div>
                                    <div class="field-item" draggable="true" data-type="date">
                                        📅 Date
                                    </div>
                                    <div class="field-item" draggable="true" data-type="select">
                                        📋 Select
                                    </div>
                                    <div class="field-item" draggable="true" data-type="radio">
                                        ⚪ Radio
                                    </div>
                                    <div class="field-item" draggable="true" data-type="checkbox">
                                        ☑️ Checkbox
                                    </div>
                                    <div class="field-item" draggable="true" data-type="file">
                                        📎 File Upload
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.field-palette .field-item {
    padding: 10px;
    margin: 5px 0;
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    cursor: move;
    border-radius: 4px;
}
.field-palette .field-item:hover {
    background: #e9ecef;
}
.form-builder-area {
    background: #fafafa;
    border-radius: 4px;
}
.form-field {
    padding: 15px;
    margin: 10px 0;
    border: 1px solid #ddd;
    background: white;
    border-radius: 4px;
    position: relative;
}
.field-controls {
    position: absolute;
    top: 5px;
    right: 5px;
}
.drop-zone {
    border: 2px dashed #ddd;
    background: #fafafa;
}
.drag-over {
    border-color: #007bff;
    background: #f0f8ff;
}
</style>

<script>
let formFields = @json($form->fields ?? []);
let fieldCounter = 0;

document.addEventListener('DOMContentLoaded', function() {
    setupDragDrop();
    loadExistingFields();
    
    document.getElementById('formBuilder').addEventListener('submit', function(e) {
        e.preventDefault();
        updateForm();
    });
});

function loadExistingFields() {
    if (formFields && formFields.length > 0) {
        formFields.forEach(field => {
            renderField(field);
        });
        fieldCounter = formFields.length;
    }
}

function setupDragDrop() {
    const fieldItems = document.querySelectorAll('.field-item');
    const dropZone = document.getElementById('formFields');
    
    fieldItems.forEach(item => {
        item.addEventListener('dragstart', function(e) {
            e.dataTransfer.setData('text/plain', this.dataset.type);
        });
    });
    
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('drag-over');
    });
    
    dropZone.addEventListener('dragleave', function(e) {
        this.classList.remove('drag-over');
    });
    
    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('drag-over');
        const fieldType = e.dataTransfer.getData('text/plain');
        addField(fieldType);
    });
}

function addField(type) {
    fieldCounter++;
    const fieldId = `field_${fieldCounter}`;
    
    const fieldLabels = {
        'text': 'Text Field',
        'email': 'Email Address',
        'tel': 'Phone Number', 
        'number': 'Number Field',
        'textarea': 'Text Area',
        'date': 'Date Field',
        'select': 'Select Dropdown',
        'radio': 'Radio Buttons',
        'checkbox': 'Checkboxes',
        'file': 'File Upload'
    };

    const field = {
        id: fieldId,
        type: type,
        label: fieldLabels[type] || 'Field',
        name: fieldId,
        placeholder: '',
        required: false,
        options: (type === 'select' || type === 'radio' || type === 'checkbox') ? ['Option 1', 'Option 2'] : null
    };

    formFields.push(field);
    renderField(field);
    
    // Clear placeholder text
    const dropZone = document.getElementById('formFields');
    const placeholder = dropZone.querySelector('h5');
    if (placeholder) placeholder.remove();
}

function renderField(field) {
    const formFieldsArea = document.getElementById('formFields');
    const fieldHtml = `
        <div class="form-field" data-field-id="${field.id}">
            <div class="field-controls">
                <button type="button" class="btn btn-sm btn-warning" onclick="editField('${field.id}')">⚙️</button>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeField('${field.id}')">🗑️</button>
            </div>
            <div class="form-group">
                <label><strong>${field.label} ${field.required ? '*' : ''}</strong></label>
                ${generateFieldInput(field)}
            </div>
        </div>
    `;
    formFieldsArea.insertAdjacentHTML('beforeend', fieldHtml);
}

function generateFieldInput(field) {
    const placeholder = field.placeholder || `Enter ${field.label.toLowerCase()}`;
    const required = field.required ? 'required' : '';
    
    switch(field.type) {
        case 'textarea':
            return `<textarea class="form-control" name="${field.name}" placeholder="${placeholder}" rows="3" ${required}></textarea>`;
        case 'select':
            const options = field.options ? field.options.map(opt => `<option value="${opt}">${opt}</option>`).join('') : '';
            return `<select class="form-control" name="${field.name}" ${required}><option value="">Choose...</option>${options}</select>`;
        case 'radio':
            return field.options ? field.options.map(opt =>
                `<div class="form-check">
                    <input class="form-check-input" type="radio" name="${field.name}" value="${opt}" ${required}>
                    <label class="form-check-label">${opt}</label>
                </div>`
            ).join('') : '';
        case 'checkbox':
            return field.options ? field.options.map(opt =>
                `<div class="form-check">
                    <input class="form-check-input" type="checkbox" name="${field.name}[]" value="${opt}">
                    <label class="form-check-label">${opt}</label>
                </div>`
            ).join('') : '';
        case 'tel':
            return `<input type="tel" class="form-control" name="${field.name}" placeholder="${placeholder}" ${required}>`;
        case 'date':
            return `<input type="date" class="form-control" name="${field.name}" ${required}>`;
        case 'file':
            return `<input type="file" class="form-control" name="${field.name}" ${required}>`;
        default:
            return `<input type="${field.type}" class="form-control" name="${field.name}" placeholder="${placeholder}" ${required}>`;
    }
}

function editField(fieldId) {
    const field = formFields.find(f => f.id === fieldId);
    const newLabel = prompt('Enter field label:', field.label);
    if (newLabel) {
        field.label = newLabel;
        field.placeholder = prompt('Enter placeholder:', field.placeholder || '');
        field.required = confirm('Is this field required?');
        
        if (field.options) {
            const optionsStr = prompt('Enter options (comma separated):', field.options.join(', '));
            if (optionsStr) {
                field.options = optionsStr.split(',').map(opt => opt.trim());
            }
        }
        
        // Re-render field
        document.querySelector(`[data-field-id="${fieldId}"]`).remove();
        renderField(field);
    }
}

function removeField(fieldId) {
    if (confirm('Remove this field?')) {
        formFields = formFields.filter(f => f.id !== fieldId);
        document.querySelector(`[data-field-id="${fieldId}"]`).remove();
        
        if (formFields.length === 0) {
            document.getElementById('formFields').innerHTML = '<h5 class="text-muted">Drag fields here to build your form</h5>';
        }
    }
}

function updateForm() {
    const formData = {
        title: document.getElementById('formTitle').value,
        description: document.getElementById('formDescription').value,
        fields: formFields,
        is_active: true
    };
    
    fetch('/admin/forms/{{ $form->id }}', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Form updated successfully!');
            window.location.href = '/admin/forms/{{ $form->id }}';
        } else {
            alert('Error updating form');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating form');
    });
}
</script>
@endsection