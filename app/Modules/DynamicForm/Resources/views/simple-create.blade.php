@extends('admin.main.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>Simple Form Builder</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h5>Drag Fields</h5>
                            <div class="field-items">
                                <div class="field-item" draggable="true" data-type="text">📝 Text Field</div>
                                <div class="field-item" draggable="true" data-type="email">📧 Email</div>
                                <div class="field-item" draggable="true" data-type="tel">📞 Phone</div>
                                <div class="field-item" draggable="true" data-type="date">📅 Date</div>
                                <div class="field-item" draggable="true" data-type="textarea">📄 Address</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Form Preview</h5>
                            <div id="form-builder" class="drop-zone">
                                <p class="text-muted">Drag fields here to build form</p>
                            </div>
                            <br>
                            <button onclick="saveForm()" class="btn btn-success">Save Form</button>
                        </div>
                        
                        <div class="col-md-3">
                            <h5>Form Settings</h5>
                            <input type="text" id="form-title" placeholder="Form Title" class="form-control mb-2" value="Personal Information Form">
                            <textarea id="form-desc" placeholder="Description" class="form-control" rows="3">Please fill your personal details</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.field-items .field-item {
    padding: 10px;
    margin: 5px 0;
    background: #f8f9fa;
    border: 1px solid #ddd;
    cursor: grab;
    border-radius: 5px;
    text-align: center;
}
.field-item:hover { background: #e9ecef; }
.drop-zone {
    min-height: 400px;
    border: 2px dashed #ddd;
    padding: 20px;
    border-radius: 5px;
    background: #fafafa;
}
.form-field {
    margin: 15px 0;
    padding: 15px;
    border: 1px solid #ddd;
    background: white;
    border-radius: 5px;
    position: relative;
}
.field-controls {
    position: absolute;
    top: 5px;
    right: 5px;
}
.drag-over { border-color: #007bff; background: #f0f8ff; }
</style>

<script>
let formFields = [];
let fieldCounter = 0;

document.addEventListener('DOMContentLoaded', function() {
    setupDragDrop();
});

function setupDragDrop() {
    const fieldItems = document.querySelectorAll('.field-item');
    const dropZone = document.getElementById('form-builder');
    
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
        'text': 'Full Name',
        'email': 'Email Address', 
        'tel': 'Phone Number',
        'date': 'Date of Birth',
        'textarea': 'Address'
    };
    
    const field = {
        id: fieldId,
        type: type,
        label: fieldLabels[type] || 'Field',
        name: fieldId,
        required: true
    };
    
    formFields.push(field);
    renderField(field);
}

function renderField(field) {
    const dropZone = document.getElementById('form-builder');
    
    if (dropZone.querySelector('p')) {
        dropZone.innerHTML = '';
    }
    
    const fieldHtml = `
        <div class="form-field" data-field-id="${field.id}">
            <div class="field-controls">
                <button type="button" class="btn btn-sm btn-warning" onclick="editField('${field.id}')">✏️</button>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeField('${field.id}')">🗑️</button>
            </div>
            <div class="form-group">
                <label><strong>${field.label} ${field.required ? '*' : ''}</strong></label>
                ${generateInput(field)}
            </div>
        </div>
    `;
    
    dropZone.insertAdjacentHTML('beforeend', fieldHtml);
}

function generateInput(field) {
    switch(field.type) {
        case 'textarea':
            return `<textarea class="form-control" name="${field.name}" placeholder="Enter ${field.label.toLowerCase()}" rows="3"></textarea>`;
        case 'date':
            return `<input type="date" class="form-control" name="${field.name}">`;
        case 'tel':
            return `<input type="tel" class="form-control" name="${field.name}" placeholder="Enter phone number">`;
        case 'email':
            return `<input type="email" class="form-control" name="${field.name}" placeholder="Enter email address">`;
        default:
            return `<input type="text" class="form-control" name="${field.name}" placeholder="Enter ${field.label.toLowerCase()}">`;
    }
}

function editField(fieldId) {
    const field = formFields.find(f => f.id === fieldId);
    const newLabel = prompt('Enter field label:', field.label);
    if (newLabel) {
        field.label = newLabel;
        field.required = confirm('Is this field required?');
        
        // Re-render
        document.querySelector(`[data-field-id="${fieldId}"]`).remove();
        renderField(field);
    }
}

function removeField(fieldId) {
    formFields = formFields.filter(f => f.id !== fieldId);
    document.querySelector(`[data-field-id="${fieldId}"]`).remove();
    
    if (formFields.length === 0) {
        document.getElementById('form-builder').innerHTML = '<p class="text-muted">Drag fields here to build form</p>';
    }
}

function saveForm() {
    const title = document.getElementById('form-title').value;
    const description = document.getElementById('form-desc').value;
    
    if (!title || formFields.length === 0) {
        alert('Please add form title and at least one field');
        return;
    }
    
    const formData = {
        title: title,
        description: description,
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
        } else {
            alert('Error saving form');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error saving form');
    });
}
</script>
@endsection