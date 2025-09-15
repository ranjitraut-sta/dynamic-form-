<!DOCTYPE html>
<html>
<head>
    <title>Form Builder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-light">
    <!-- Top Toolbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-magic"></i> Form Builder
            </a>
            <div class="navbar-nav ms-auto">
                <button class="btn btn-success me-2" onclick="saveForm()">
                    <i class="fas fa-save"></i> Save
                </button>
                <button class="btn btn-info me-2" onclick="previewForm()">
                    <i class="fas fa-eye"></i> Preview
                </button>
                <a href="{{ route('forms.index') }}" class="btn btn-outline-light">
                    <i class="fas fa-times"></i> Close
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Left Sidebar - Field Palette -->
            <div class="col-md-3 bg-white border-end" id="fieldPalette">
                <div class="p-3">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-plus-circle text-primary"></i> Add Elements
                    </h6>

                    <!-- Basic Fields -->
                    <div class="mb-4">
                        <h6 class="text-muted small mb-2">BASIC FIELDS</h6>
                        <div class="row g-2" id="basicFields">
                            <!-- Fields will be loaded here -->
                        </div>
                    </div>

                    <!-- Advanced Fields -->
                    <div class="mb-4">
                        <h6 class="text-muted small mb-2">ADVANCED</h6>
                        <div class="row g-2" id="advancedFields">
                            <!-- Advanced fields -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Center - Form Builder -->
            <div class="col-md-6">
                <div class="form-builder-container">
                    <!-- Form Header -->
                    <div class="form-header p-4 bg-white border-bottom">
                        <input type="text" id="formTitle" class="form-control form-control-lg border-0 fw-bold"
                               placeholder="Untitled Form" value="{{ $form->title ?? '' }}">
                        <textarea id="formDescription" class="form-control border-0 mt-2" rows="2"
                                  placeholder="Form description">{{ $form->description ?? '' }}</textarea>
                    </div>

                    <!-- Form Fields Area -->
                    <div class="form-fields-area p-4" id="formFields">
                        <div class="empty-state text-center py-5" id="emptyState">
                            <i class="fas fa-mouse-pointer fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Drag elements here to build your form</h5>
                            <p class="text-muted">Choose from the elements on the left to get started</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar - Properties -->
            <div class="col-md-3 bg-white border-start" id="propertiesPanel">
                <div class="p-3">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-cog text-primary"></i> Properties
                    </h6>

                    <div id="fieldProperties">
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-hand-pointer fa-2x mb-2"></i>
                            <p>Select a field to edit its properties</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="previewContent">
                    <!-- Preview content -->
                </div>
            </div>
        </div>
    </div>

    <style>
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

    .form-builder-container {
        min-height: calc(100vh - 56px);
        background: #f8f9fa;
    }

    .field-item {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 12px;
        cursor: grab;
        transition: all 0.2s;
        text-align: center;
    }

    .field-item:hover {
        border-color: #0d6efd;
        box-shadow: 0 2px 8px rgba(13,110,253,0.15);
        transform: translateY(-1px);
    }

    .field-item:active { cursor: grabbing; }

    .field-item i {
        font-size: 24px;
        color: #6c757d;
        margin-bottom: 8px;
        display: block;
    }

    .field-item span {
        font-size: 11px;
        font-weight: 600;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-field {
        background: white;
        border: 2px solid transparent;
        border-radius: 8px;
        padding: 20px;
        margin: 15px 0;
        position: relative;
        cursor: pointer;
        transition: all 0.2s;
    }

    .form-field:hover {
        border-color: #0d6efd;
        box-shadow: 0 4px 12px rgba(13,110,253,0.15);
    }

    .form-field.selected {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13,110,253,0.1);
    }

    .field-controls {
        position: absolute;
        top: -15px;
        right: 10px;
        background: white;
        border-radius: 20px;
        padding: 5px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        opacity: 0;
        transition: opacity 0.2s;
    }

    .form-field:hover .field-controls {
        opacity: 1;
    }

    .drop-zone {
        min-height: 60px;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        margin: 10px 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .drop-zone.drag-over {
        border-color: #0d6efd;
        background: rgba(13,110,253,0.05);
    }

    .properties-group {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }

    .properties-group h6 {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        color: #6c757d;
        margin-bottom: 10px;
    }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    let formFields = @json($form->fields ?? []);
    let fieldCounter = formFields.length;
    let selectedField = null;
    let dragDropInitialized = false;

    document.addEventListener('DOMContentLoaded', function() {
        loadFieldPalette();
        loadExistingFields();
    });

    function loadFieldPalette() {
        fetch('/admin/field-palette')
            .then(response => response.json())
            .then(data => {
                // Parse the HTML and create JotForm-style field items
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = data.html;

                const basicFields = document.getElementById('basicFields');
                const advancedFields = document.getElementById('advancedFields');

                const fieldCards = tempDiv.querySelectorAll('.field-card');
                fieldCards.forEach((card, index) => {
                    const fieldType = card.dataset.type;
                    const icon = card.querySelector('i').className;
                    const label = card.querySelector('.field-name').textContent;

                    const fieldItem = createFieldItem(fieldType, icon, label);

                    if (index < 6) {
                        basicFields.appendChild(fieldItem);
                    } else {
                        advancedFields.appendChild(fieldItem);
                    }
                });

                if (!dragDropInitialized) {
                    setupDragDrop();
                    dragDropInitialized = true;
                }
            });
    }

    function createFieldItem(type, icon, label) {
        const div = document.createElement('div');
        div.className = 'col-6';
        div.innerHTML = `
            <div class="field-item" draggable="true" data-type="${type}">
                <i class="${icon}"></i>
                <span>${label}</span>
            </div>
        `;
        return div;
    }

    function loadExistingFields() {
        if (formFields.length > 0) {
            document.getElementById('emptyState').style.display = 'none';
            formFields.forEach(field => renderField(field));
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
        });

        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            const fieldType = e.dataTransfer.getData('text/plain');
            if (fieldType) {
                addField(fieldType);
            }
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
        selectField(fieldId);

        document.getElementById('emptyState').style.display = 'none';
    }

    function renderField(field) {
        const formFieldsArea = document.getElementById('formFields');
        const fieldHtml = `
            <div class="form-field" data-field-id="${field.id}" onclick="selectField('${field.id}')">
                <div class="field-controls">
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="event.stopPropagation(); duplicateField('${field.id}')" title="Duplicate">
                        <i class="fas fa-copy"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="event.stopPropagation(); removeField('${field.id}')" title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="field-content">
                    <label class="form-label fw-bold">${field.label} ${field.required ? '<span class="text-danger">*</span>' : ''}</label>
                    ${generateFieldPreview(field)}
                </div>
            </div>
        `;
        formFieldsArea.insertAdjacentHTML('beforeend', fieldHtml);
    }

    function generateFieldPreview(field) {
        const placeholder = field.placeholder || `Enter ${field.label.toLowerCase()}`;

        switch(field.type) {
            case 'textarea':
                return `<textarea class="form-control" placeholder="${placeholder}" rows="3" disabled></textarea>`;
            case 'select':
                const options = field.options ? field.options.map(opt => `<option>${opt}</option>`).join('') : '';
                return `<select class="form-control" disabled><option>Choose...</option>${options}</select>`;
            case 'radio':
                return field.options ? field.options.map(opt =>
                    `<div class="form-check"><input class="form-check-input" type="radio" disabled><label class="form-check-label">${opt}</label></div>`
                ).join('') : '';
            case 'checkbox':
                return field.options ? field.options.map(opt =>
                    `<div class="form-check"><input class="form-check-input" type="checkbox" disabled><label class="form-check-label">${opt}</label></div>`
                ).join('') : '';
            case 'date':
                return `<input type="date" class="form-control" disabled>`;
            case 'file':
                return `<input type="file" class="form-control" disabled>`;
            default:
                return `<input type="${field.type}" class="form-control" placeholder="${placeholder}" disabled>`;
        }
    }

    function selectField(fieldId) {
        // Remove previous selection
        document.querySelectorAll('.form-field').forEach(f => f.classList.remove('selected'));

        // Select current field
        const fieldElement = document.querySelector(`[data-field-id="${fieldId}"]`);
        fieldElement.classList.add('selected');

        selectedField = formFields.find(f => f.id === fieldId);
        showFieldProperties(selectedField);
    }

    function showFieldProperties(field) {
        const propertiesPanel = document.getElementById('fieldProperties');

        propertiesPanel.innerHTML = `
            <div class="properties-group">
                <h6>Basic</h6>
                <div class="mb-3">
                    <label class="form-label">Label</label>
                    <input type="text" class="form-control" value="${field.label}" onchange="updateField('label', this.value)">
                </div>
                <div class="mb-3">
                    <label class="form-label">Placeholder</label>
                    <input type="text" class="form-control" value="${field.placeholder || ''}" onchange="updateField('placeholder', this.value)">
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" ${field.required ? 'checked' : ''} onchange="updateField('required', this.checked)">
                    <label class="form-check-label">Required field</label>
                </div>
            </div>

            ${field.options ? `
            <div class="properties-group">
                <h6>Options</h6>
                <div id="optionsList">
                    ${field.options.map((opt, i) => `
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" value="${opt}" onchange="updateOption(${i}, this.value)">
                            <button class="btn btn-outline-danger" onclick="removeOption(${i})">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `).join('')}
                </div>
                <button class="btn btn-sm btn-outline-primary" onclick="addOption()">
                    <i class="fas fa-plus"></i> Add Option
                </button>
            </div>
            ` : ''}
        `;
    }

    function updateField(property, value) {
        if (selectedField) {
            selectedField[property] = value;
            refreshField(selectedField.id);
        }
    }

    function refreshField(fieldId) {
        const fieldElement = document.querySelector(`[data-field-id="${fieldId}"]`);
        const field = formFields.find(f => f.id === fieldId);

        fieldElement.querySelector('.field-content').innerHTML = `
            <label class="form-label fw-bold">${field.label} ${field.required ? '<span class="text-danger">*</span>' : ''}</label>
            ${generateFieldPreview(field)}
        `;
    }

    function removeField(fieldId) {
        if (confirm('Delete this field?')) {
            formFields = formFields.filter(f => f.id !== fieldId);
            document.querySelector(`[data-field-id="${fieldId}"]`).remove();

            if (formFields.length === 0) {
                document.getElementById('emptyState').style.display = 'block';
            }

            document.getElementById('fieldProperties').innerHTML = `
                <div class="text-center text-muted py-4">
                    <i class="fas fa-hand-pointer fa-2x mb-2"></i>
                    <p>Select a field to edit its properties</p>
                </div>
            `;
        }
    }

    function saveForm() {
        const formData = {
            title: document.getElementById('formTitle').value || 'Untitled Form',
            description: document.getElementById('formDescription').value,
            fields: formFields,
            is_active: true
        };

        const url = '{{ isset($form) ? "/admin/forms/" . $form->id : "/admin/forms" }}';
        const method = '{{ isset($form) ? "PUT" : "POST" }}';

        fetch(url, {
            method: method,
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

    function previewForm() {
        // Generate preview HTML
        let previewHtml = `
            <form>
                <h4>${document.getElementById('formTitle').value || 'Untitled Form'}</h4>
                <p class="text-muted">${document.getElementById('formDescription').value}</p>
        `;

        formFields.forEach(field => {
            previewHtml += `
                <div class="mb-3">
                    <label class="form-label">${field.label} ${field.required ? '<span class="text-danger">*</span>' : ''}</label>
                    ${generateFieldPreview(field).replace('disabled', '')}
                </div>
            `;
        });

        previewHtml += `
                <button type="button" class="btn btn-primary">Submit Form</button>
            </form>
        `;

        document.getElementById('previewContent').innerHTML = previewHtml;
        new bootstrap.Modal(document.getElementById('previewModal')).show();
    }
    </script>
</body>
</html>
