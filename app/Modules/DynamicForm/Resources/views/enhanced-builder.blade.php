<!DOCTYPE html>
<html>
<head>
    <title>Enhanced Form Builder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-light">
    <!-- Top Toolbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-magic"></i> Enhanced Form Builder
            </a>
            <div class="navbar-nav ms-auto">
                <button class="btn btn-outline-light me-2" onclick="showFormSettings()">
                    <i class="fas fa-cog"></i> Settings
                </button>
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
            <!-- Left Sidebar -->
            <div class="col-md-3 bg-white border-end">
                <div class="p-3">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-plus-circle text-primary"></i> Add Elements
                    </h6>
                    <div class="mb-4">
                        <h6 class="text-muted small mb-2">BASIC FIELDS</h6>
                        <div class="row g-2" id="basicFields"></div>
                    </div>
                    <div class="mb-4">
                        <h6 class="text-muted small mb-2">ADVANCED</h6>
                        <div class="row g-2" id="advancedFields"></div>
                    </div>
                </div>
            </div>

            <!-- Center - Form Builder -->
            <div class="col-md-6">
                <div class="form-builder-container">
                    <div class="form-header p-4 bg-white border-bottom">
                        <input type="text" id="formTitle" class="form-control form-control-lg border-0 fw-bold"
                               placeholder="Untitled Form" value="{{ $form->title ?? '' }}">
                        <textarea id="formDescription" class="form-control border-0 mt-2" rows="2"
                                  placeholder="Form description">{{ $form->description ?? '' }}</textarea>
                    </div>
                    <div class="form-fields-area p-4" id="formFields">
                        <div class="empty-state text-center py-5" id="emptyState">
                            <i class="fas fa-mouse-pointer fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Drag elements here to build your form</h5>
                            <p class="text-muted">Choose from the elements on the left to get started</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="col-md-3 bg-white border-start">
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

    <!-- Templates Modal -->
    <div class="modal fade" id="templatesModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Choose Template</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row" id="templatesGrid"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Conditional Logic Modal -->
    <div class="modal fade" id="conditionalModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Conditional Logic</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Conditional logic builder coming soon...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Settings Modal -->
    <div class="modal fade" id="settingsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Form settings coming soon...</p>
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
                <div class="modal-body" id="previewContent"></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    // Global variables
    let formFields = @json($form->fields ?? []);
    let fieldCounter = formFields.length;

    // Initialize on document ready
    $(document).ready(function() {
        loadFieldPalette();
        loadExistingFields();
    });

    // Show templates modal
    function showTemplates() {
        renderTemplates();
        $('#templatesModal').modal('show');
    }

    // Render template options
    function renderTemplates() {
        const templates = [
            {id: 'contact', name: 'Contact Form', description: 'Simple contact form'},
            {id: 'survey', name: 'Customer Survey', description: 'Satisfaction survey'},
            {id: 'registration', name: 'Event Registration', description: 'Registration form'}
        ];

        let html = '';
        templates.forEach(template => {
            html += `
                <div class="col-md-4 mb-3">
                    <div class="card template-card h-100" onclick="loadTemplate('${template.id}')">
                        <div class="card-body text-center">
                            <i class="fas fa-file-alt fa-3x text-primary mb-2"></i>
                            <h6>${template.name}</h6>
                            <p class="small text-muted">${template.description}</p>
                        </div>
                    </div>
                </div>
            `;
        });
        $('#templatesGrid').html(html);
    }

    // Load template
    function loadTemplate(templateId) {
        const templates = {
            'contact': {
                fields: [
                    {id: 'name', type: 'text', label: 'Full Name', required: true},
                    {id: 'email', type: 'email', label: 'Email Address', required: true},
                    {id: 'message', type: 'textarea', label: 'Message', required: true}
                ]
            },
            'survey': {
                fields: [
                    {id: 'satisfaction', type: 'text', label: 'Overall Satisfaction', required: true},
                    {id: 'comments', type: 'textarea', label: 'Comments', required: false}
                ]
            },
            'registration': {
                fields: [
                    {id: 'first_name', type: 'text', label: 'First Name', required: true},
                    {id: 'last_name', type: 'text', label: 'Last Name', required: true},
                    {id: 'email', type: 'email', label: 'Email', required: true}
                ]
            }
        };

        if (templates[templateId]) {
            formFields = templates[templateId].fields;
            fieldCounter = formFields.length;
            renderFormFields();
            $('#templatesModal').modal('hide');
            alert('Template loaded successfully!');
        }
    }

    // Show conditional logic modal
    function showConditionalLogic() {
        $('#conditionalModal').modal('show');
    }

    // Show form settings modal
    function showFormSettings() {
        $('#settingsModal').modal('show');
    }

    // Save form
    function saveForm() {
        const formData = {
            title: $('#formTitle').val(),
            description: $('#formDescription').val(),
            fields: formFields
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.post('/admin/forms/{{ $form->id ?? "" }}', {
            ...formData,
            _method: 'PUT'
        }).done(function() {
            alert('Form saved successfully!');
        }).fail(function() {
            alert('Error saving form');
        });
    }

    // Preview form
    function previewForm() {
        let html = '<form class="preview-form">';
        formFields.forEach(field => {
            html += `
                <div class="mb-3">
                    <label class="form-label">${field.label} ${field.required ? '*' : ''}</label>
                    ${renderFieldInput(field)}
                </div>
            `;
        });
        html += '<button type="submit" class="btn btn-primary">Submit</button></form>';
        $('#previewContent').html(html);
        $('#previewModal').modal('show');
    }

    // Render field input for preview
    function renderFieldInput(field) {
        switch (field.type) {
            case 'text':
            case 'email':
                return `<input type="${field.type}" class="form-control" placeholder="${field.placeholder || ''}">`;
            case 'textarea':
                return `<textarea class="form-control" placeholder="${field.placeholder || ''}"></textarea>`;
            case 'select':
                return `<select class="form-select"><option>Select option</option></select>`;
            default:
                return `<input type="text" class="form-control">`;
        }
    }

    // Load field palette
    function loadFieldPalette() {
        const basicFields = [
            {type: 'text', icon: 'fas fa-font', label: 'Text'},
            {type: 'email', icon: 'fas fa-envelope', label: 'Email'},
            {type: 'textarea', icon: 'fas fa-align-left', label: 'Textarea'},
            {type: 'select', icon: 'fas fa-list', label: 'Dropdown'},
            {type: 'radio', icon: 'fas fa-dot-circle', label: 'Radio'},
            {type: 'checkbox', icon: 'fas fa-check-square', label: 'Checkbox'},
            {type: 'date', icon: 'fas fa-calendar', label: 'Date'},
            {type: 'number', icon: 'fas fa-hashtag', label: 'Number'}
        ];

        const advancedFields = [
            {type: 'file', icon: 'fas fa-upload', label: 'File'},
            {type: 'rating', icon: 'fas fa-star', label: 'Rating'},
            {type: 'signature', icon: 'fas fa-signature', label: 'Signature'},
            {type: 'slider', icon: 'fas fa-sliders-h', label: 'Slider'}
        ];

        let basicHtml = '';
        basicFields.forEach(field => {
            basicHtml += `
                <div class="col-6 mb-2">
                    <div class="field-item" onclick="addFieldToForm('${field.type}')">
                        <i class="${field.icon}"></i>
                        <span>${field.label}</span>
                    </div>
                </div>
            `;
        });
        $('#basicFields').html(basicHtml);

        let advancedHtml = '';
        advancedFields.forEach(field => {
            advancedHtml += `
                <div class="col-6 mb-2">
                    <div class="field-item" onclick="addFieldToForm('${field.type}')">
                        <i class="${field.icon}"></i>
                        <span>${field.label}</span>
                    </div>
                </div>
            `;
        });
        $('#advancedFields').html(advancedHtml);
    }

    // Add field to form
    function addFieldToForm(fieldType) {
        const field = {
            id: 'field_' + (++fieldCounter),
            type: fieldType,
            label: getDefaultLabel(fieldType),
            required: false,
            placeholder: ''
        };
        formFields.push(field);
        renderFormFields();
    }

    // Get default label for field type
    function getDefaultLabel(type) {
        const labels = {
            text: 'Text Field',
            email: 'Email Address',
            textarea: 'Text Area',
            select: 'Dropdown',
            radio: 'Radio Buttons',
            checkbox: 'Checkboxes',
            date: 'Date',
            number: 'Number',
            file: 'File Upload',
            rating: 'Rating',
            signature: 'Signature',
            slider: 'Slider'
        };
        return labels[type] || 'Field';
    }

    // Load existing fields
    function loadExistingFields() {
        if (formFields.length > 0) {
            renderFormFields();
        }
    }

    // Render form fields
    function renderFormFields() {
        if (formFields.length === 0) {
            $('#emptyState').show();
            return;
        }

        $('#emptyState').hide();
        let html = '';
        formFields.forEach((field, index) => {
            html += `
                <div class="form-field" data-field-id="${field.id}">
                    <div class="field-controls">
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteField(${index})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <label class="form-label">${field.label} ${field.required ? '<span class="text-danger">*</span>' : ''}</label>
                    ${renderFieldInput(field)}
                </div>
            `;
        });
        $('#formFields').html(html);
    }

    // Delete field
    function deleteField(index) {
        formFields.splice(index, 1);
        renderFormFields();
    }
    </script>

    <style>
    .field-item {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 12px;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
    }

    .field-item:hover {
        border-color: #0d6efd;
        box-shadow: 0 2px 8px rgba(13,110,253,0.15);
        transform: translateY(-1px);
    }

    .field-item i {
        font-size: 20px;
        color: #6c757d;
        margin-bottom: 5px;
        display: block;
    }

    .field-item span {
        font-size: 10px;
        font-weight: 600;
        color: #495057;
        text-transform: uppercase;
    }

    .form-field {
        background: white;
        border: 2px solid transparent;
        border-radius: 8px;
        padding: 20px;
        margin: 15px 0;
        position: relative;
        transition: all 0.2s;
    }

    .form-field:hover {
        border-color: #0d6efd;
        box-shadow: 0 4px 12px rgba(13,110,253,0.15);
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

    .template-card {
        cursor: pointer;
        transition: all 0.2s;
    }

    .template-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    </style>
</body>
</html>
