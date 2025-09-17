<!DOCTYPE html>
<html>
<head>
    <title>Create New Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Header -->
                <div class="text-center py-5">
                    <h1 class="display-5 fw-bold text-primary">
                        <i class="fas fa-magic me-2"></i>Create Your Form
                    </h1>
                    <p class="lead text-muted">Choose a template to get started or build from scratch</p>
                </div>

                <!-- Template Selection -->
                <div class="row g-4 mb-5">
                    <!-- Start from Scratch -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="template-option h-100" onclick="createBlankForm()">
                            <div class="template-card h-100 border-2 border-dashed">
                                <div class="card-body text-center d-flex flex-column justify-content-center" style="min-height: 300px;">
                                    <div class="template-icon mb-3">
                                        <i class="fas fa-plus-circle fa-4x text-primary"></i>
                                    </div>
                                    <h5 class="card-title">Start from Scratch</h5>
                                    <p class="card-text text-muted">Build your form from the ground up with complete control</p>
                                    <div class="mt-auto">
                                        <span class="badge bg-primary">Blank Form</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Templates from Database -->
                <div class="row g-4 mb-5" id="templates-container">
                    <!-- Templates will be loaded here -->
                </div>

                <!-- Browse More Templates -->
                <div class="text-center py-4">
                    <button class="btn btn-outline-primary btn-lg" onclick="showAllTemplates()">
                        <i class="fas fa-search me-2"></i>Browse More Templates
                    </button>
                    <div class="mt-3">
                        <small class="text-muted">Or <a href="{{ route('forms.index') }}" class="text-decoration-none">go back to forms list</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    <div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center py-4">
                    <div class="spinner-border text-primary mb-3" role="status"></div>
                    <p class="mb-0">Creating your form...</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
    // Load templates from database
    $(document).ready(function() {
        loadTemplates();
    });

    let templatesLoaded = false;

    function loadTemplates() {
        if (templatesLoaded) return;

        $.get('/api/templates/prebuilt').done(function(templates) {
            let html = '';
            templates.forEach(function(template, index) {
                html += `
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="template-option h-100" onclick="createFromTemplate(${template.id})">
                            <div class="template-card h-100">
                                <div class="template-preview">
                                    <div class="preview-form">
                                        ${template.fields.slice(0, 4).map(field =>
                                            `<div class="form-field-preview ${field.type === 'textarea' ? 'large' : ''}">${field.label}</div>`
                                        ).join('')}
                                        <div class="submit-btn-preview">Submit</div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-${getCategoryIcon(template.category)} text-info me-2"></i>${template.name}
                                    </h5>
                                    <p class="card-text text-muted">${template.description}</p>
                                    <div class="template-stats">
                                        <small class="text-muted">
                                            <i class="fas fa-list me-1"></i>${template.fields.length} fields
                                            <i class="fas fa-clock ms-2 me-1"></i>2 min setup
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            $('#templates-container').html(html);
            templatesLoaded = true;
        });
    }

    function getCategoryIcon(category) {
        const icons = {
            'contact': 'envelope',
            'survey': 'chart-bar',
            'registration': 'user-plus',
            'feedback': 'comments'
        };
        return icons[category] || 'file-alt';
    }
    // Create blank form
    function createBlankForm() {
        showLoading();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.post('{{ route("forms.store") }}', {
            title: 'Untitled Form',
            description: '',
            fields: []
        }).done(function(response) {
            window.location.href = '/admin/forms/' + response.form.id + '/edit';
        }).fail(function() {
            hideLoading();
            alert('Error creating form');
        });
    }

    // Create from template
    function createFromTemplate(templateId) {
        showLoading();

        // Fetch template from database
        $.get('/api/templates/' + templateId).done(function(template) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.post('{{ route("forms.store") }}', {
                title: template.name,
                description: template.description,
                fields: template.fields
            }).done(function(response) {
                window.location.href = '{{ route("forms.edit", "__ID__") }}'.replace('__ID__', response.form.id);
            }).fail(function() {
                hideLoading();
                alert('Error creating form from template');
            });
        }).fail(function() {
            hideLoading();
            alert('Template not found');
        });
    }

    // Show all templates
    function showAllTemplates() {
        alert('All templates are already displayed above!');
    }

    // Show loading
    function showLoading() {
        $('#loadingModal').modal('show');
    }

    // Hide loading
    function hideLoading() {
        $('#loadingModal').modal('hide');
    }
    </script>

    <style>
    .template-option {
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .template-option:hover {
        transform: translateY(-5px);
    }

    .template-card {
        border: 1px solid #e9ecef;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        background: white;
        height: 100%;
        min-height: 400px;
    }

    .template-card:hover {
        border-color: #0d6efd;
        box-shadow: 0 8px 25px rgba(13, 110, 253, 0.15);
    }

    .template-preview {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 20px;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .preview-form {
        width: 100%;
        max-width: 200px;
    }

    .form-field-preview {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 8px 12px;
        margin-bottom: 8px;
        font-size: 12px;
        color: #6c757d;
    }

    .form-field-preview.large {
        height: 40px;
    }

    .submit-btn-preview {
        background: #0d6efd;
        color: white;
        border-radius: 4px;
        padding: 8px 16px;
        text-align: center;
        font-size: 12px;
        font-weight: 600;
    }

    .template-icon {
        opacity: 0.8;
    }

    .template-stats {
        border-top: 1px solid #f8f9fa;
        padding-top: 10px;
        margin-top: 10px;
    }

    .border-dashed {
        border-style: dashed !important;
        border-color: #0d6efd !important;
    }
    </style>
</body>
</html>
