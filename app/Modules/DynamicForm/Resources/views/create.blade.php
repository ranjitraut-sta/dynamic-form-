@extends('admin.main.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-4">
                    <h3 class="mb-0 text-dark font-weight-bold">Create Dynamic Form ✨</h3>
                    <p class="text-muted mt-2">Drag and drop fields to build your perfect form.</p>
                </div>
                <div class="card-body">
                    <form id="formBuilder">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold text-muted">Form Title</label>
                                    <input type="text" class="form-control rounded-pill form-control-lg" id="formTitle" placeholder="e.g., Contact Us Form" required>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold text-muted">Description</label>
                                    <textarea class="form-control rounded-lg" id="formDescription" rows="3" placeholder="A brief description of the form's purpose"></textarea>
                                </div>

                                <div class="form-builder-area border border-dashed rounded-lg p-4 mb-4" style="min-height: 400px;" id="formFields">
                                    <div class="d-flex justify-content-center align-items-center h-100 text-center text-muted placeholder-text">
                                        <h5 class="m-0">
                                            <i class="fas fa-hand-pointer d-block mb-2"></i>
                                            Drag fields here to build your form
                                        </h5>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('forms.index') }}" class="btn btn-light rounded-pill mr-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary rounded-pill btn-lg save-button">Save Form</button>
                                </div>
                            </div>

                            <div class="col-md-4 border-left">
                                <h5 class="mb-3 font-weight-bold text-dark">Available Fields</h5>
                                <div class="field-palette card shadow-sm p-3">
                                    <div class="field-item" draggable="true" data-type="text">
                                        <i class="fas fa-pencil-alt mr-2 text-primary"></i>Text Input
                                    </div>
                                    <div class="field-item" draggable="true" data-type="email">
                                        <i class="fas fa-envelope mr-2 text-success"></i>Email Address
                                    </div>
                                    <div class="field-item" draggable="true" data-type="tel">
                                        <i class="fas fa-phone mr-2 text-info"></i>Phone Number
                                    </div>
                                    <div class="field-item" draggable="true" data-type="number">
                                        <i class="fas fa-hashtag mr-2 text-warning"></i>Number Field
                                    </div>
                                    <div class="field-item" draggable="true" data-type="textarea">
                                        <i class="fas fa-align-left mr-2 text-secondary"></i>Text Area
                                    </div>
                                    <div class="field-item" draggable="true" data-type="date">
                                        <i class="fas fa-calendar-alt mr-2 text-danger"></i>Date
                                    </div>
                                    <div class="field-item" draggable="true" data-type="select">
                                        <i class="fas fa-list mr-2 text-primary"></i>Select Dropdown
                                    </div>
                                    <div class="field-item" draggable="true" data-type="radio">
                                        <i class="fas fa-dot-circle mr-2 text-success"></i>Radio Buttons
                                    </div>
                                    <div class="field-item" draggable="true" data-type="checkbox">
                                        <i class="fas fa-check-square mr-2 text-info"></i>Checkboxes
                                    </div>
                                    <div class="field-item" draggable="true" data-type="file">
                                        <i class="fas fa-upload mr-2 text-warning"></i>File Upload
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
let formFields = [];
let fieldCounter = 0;

document.addEventListener('DOMContentLoaded', function() {
    setupDragDrop();

    document.getElementById('formBuilder').addEventListener('submit', function(e) {
        e.preventDefault();
        saveForm();
    });
});

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
            return `<textarea class="form-control" name="${field.name}" placeholder="${placeholder}" rows="3"></textarea>`;
        case 'select':
            const options = field.options.map(opt => `<option value="${opt}">${opt}</option>`).join('');
            return `<select class="form-control" name="${field.name}"><option value="">Choose...</option>${options}</select>`;
        case 'radio':
            return field.options.map(opt =>
                `<div class="form-check">
                    <input class="form-check-input" type="radio" name="${field.name}" value="${opt}">
                    <label class="form-check-label">${opt}</label>
                </div>`
            ).join('');
        case 'checkbox':
            return field.options.map(opt =>
                `<div class="form-check">
                    <input class="form-check-input" type="checkbox" name="${field.name}[]" value="${opt}">
                    <label class="form-check-label">${opt}</label>
                </div>`
            ).join('');
        case 'tel':
            return `<input type="tel" class="form-control" name="${field.name}" placeholder="${placeholder}">`;
        case 'date':
            return `<input type="date" class="form-control" name="${field.name}">`;
        case 'file':
            return `<input type="file" class="form-control" name="${field.name}">`;
        default:
            return `<input type="${field.type}" class="form-control" name="${field.name}" placeholder="${placeholder}">`;
    }
}

function editField(fieldId) {
    const field = formFields.find(f => f.id === fieldId);

    // Create modal-like form for editing
    const modal = document.createElement('div');
    modal.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:1000;display:flex;align-items:center;justify-content:center';

    const form = document.createElement('div');
    form.style.cssText = 'background:white;padding:20px;border-radius:8px;width:400px;max-width:90%';

    form.innerHTML = `
        <h5>Edit Field Settings</h5>
        <div class="mb-3">
            <label>Field Label:</label>
            <input type="text" id="editLabel" class="form-control" value="${field.label}">
        </div>
        <div class="mb-3">
            <label>Placeholder:</label>
            <input type="text" id="editPlaceholder" class="form-control" value="${field.placeholder || ''}">
        </div>
        <div class="mb-3">
            <label>
                <input type="checkbox" id="editRequired" ${field.required ? 'checked' : ''}> Required Field
            </label>
        </div>
        ${field.options ? `
        <div class="mb-3">
            <label>Options (one per line):</label>
            <textarea id="editOptions" class="form-control" rows="3">${field.options.join('\n')}</textarea>
        </div>` : ''}
        <div class="mb-3">
            ${getValidationOptions(field.type)}
        </div>
        <button onclick="saveFieldEdit('${fieldId}')" class="btn btn-primary">Save</button>
        <button onclick="closeEditModal()" class="btn btn-secondary">Cancel</button>
    `;

    modal.appendChild(form);
    document.body.appendChild(modal);
    window.currentModal = modal;
}

function getValidationOptions(type) {
    switch(type) {
        case 'email':
            return '<label><input type="checkbox" id="emailOnly"> Email validation only</label>';
        case 'number':
            return `
                <label>Min Value: <input type="number" id="minValue" class="form-control" style="width:100px;display:inline"></label><br>
                <label>Max Value: <input type="number" id="maxValue" class="form-control" style="width:100px;display:inline"></label>
            `;
        case 'text':
            return `
                <label>Min Length: <input type="number" id="minLength" class="form-control" style="width:100px;display:inline"></label><br>
                <label>Max Length: <input type="number" id="maxLength" class="form-control" style="width:100px;display:inline"></label>
            `;
        case 'file':
            return '<label>Allowed Types: <input type="text" id="fileTypes" class="form-control" placeholder=".jpg,.png,.pdf"></label>';
        default:
            return '';
    }
}

function saveFieldEdit(fieldId) {
    const field = formFields.find(f => f.id === fieldId);

    field.label = document.getElementById('editLabel').value;
    field.placeholder = document.getElementById('editPlaceholder').value;
    field.required = document.getElementById('editRequired').checked;

    if (field.options) {
        const optionsText = document.getElementById('editOptions').value;
        field.options = optionsText.split('\n').filter(opt => opt.trim()).map(opt => opt.trim());
    }

    // Save validation rules
    field.validation = {};
    if (document.getElementById('emailOnly')) field.validation.emailOnly = document.getElementById('emailOnly').checked;
    if (document.getElementById('minValue')) field.validation.min = document.getElementById('minValue').value;
    if (document.getElementById('maxValue')) field.validation.max = document.getElementById('maxValue').value;
    if (document.getElementById('minLength')) field.validation.minLength = document.getElementById('minLength').value;
    if (document.getElementById('maxLength')) field.validation.maxLength = document.getElementById('maxLength').value;
    if (document.getElementById('fileTypes')) field.validation.fileTypes = document.getElementById('fileTypes').value;

    // Re-render field
    document.querySelector(`[data-field-id="${fieldId}"]`).remove();
    renderField(field);

    closeEditModal();
}

function closeEditModal() {
    if (window.currentModal) {
        document.body.removeChild(window.currentModal);
        window.currentModal = null;
    }
}

function removeField(fieldId) {
    if (confirm('Remove this field?')) {
        formFields = formFields.filter(f => f.id !== fieldId);
        document.querySelector(`[data-field-id="${fieldId}"]`).remove();

        // Show placeholder if no fields
        if (formFields.length === 0) {
            document.getElementById('formFields').innerHTML = '<h5 class="text-muted">Drag fields here to build your form</h5>';
        }
    }
}

function saveForm() {
    const formData = {
        title: document.getElementById('formTitle').value,
        description: document.getElementById('formDescription').value,
        fields: formFields,
        is_active: true
    };

    fetch('/admin/forms', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Form saved successfully!');
            window.location.href = '/admin/forms';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error saving form');
    });
}
</script>
@endsection
