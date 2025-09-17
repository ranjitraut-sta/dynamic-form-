<!DOCTYPE html>
<html>
<head>
    <title>My Forms - Workspace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-light">
    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="{{ route('adminLayout') }}" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 1.8rem;">
                <i class="fas fa-magic me-2" style="color: #667eea;"></i>Dashboard
            </a>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-xl-2 col-lg-3 d-none d-lg-block bg-white border-end vh-100 p-0">
                <div class="sidebar-nav">
                    <div class="p-4">
                        <h6 class="text-muted text-uppercase fw-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">Workspace</h6>
                        <ul class="nav flex-column">
                            <li class="nav-item mb-1">
                                <a class="nav-link active d-flex align-items-center py-3" href="#" style="border-radius: 12px;">
                                    <div class="nav-icon me-3">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <span class="fw-medium">My Forms</span>
                                </a>
                            </li>
                            <li class="nav-item mb-1">
                                <a class="nav-link d-flex align-items-center py-3" href="#" style="border-radius: 12px;">
                                    <div class="nav-icon me-3">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <span class="fw-medium">Analytics</span>
                                </a>
                            </li>
                            <li class="nav-item mb-1">
                                <a class="nav-link d-flex align-items-center py-3" href="#" style="border-radius: 12px;">
                                    <div class="nav-icon me-3">
                                        <i class="fas fa-folder"></i>
                                    </div>
                                    <span class="fw-medium">Templates</span>
                                </a>
                            </li>
                            <li class="nav-item mb-1">
                                <a class="nav-link d-flex align-items-center py-3" href="#" style="border-radius: 12px;">
                                    <div class="nav-icon me-3">
                                        <i class="fas fa-trash"></i>
                                    </div>
                                    <span class="fw-medium">Trash</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-xl-10 col-lg-9 col-12 p-4" style="background: #fafbfc;">
                <!-- Header Section -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5">
                    <div class="mb-3 mb-md-0">
                        <h1 class="fw-bold mb-2" style="font-size: 2.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">My Forms</h1>
                        <p class="text-muted mb-0 fs-5">Create and manage your forms with ease</p>
                    </div>
                    <div class="d-flex flex-column flex-sm-row gap-3 align-items-stretch align-items-sm-center">
                        <div class="btn-group shadow-sm" role="group" style="border-radius: 12px; overflow: hidden;">
                            <button class="btn btn-outline-primary active px-4" id="gridView" style="border-radius: 0;">
                                <i class="fas fa-th-large me-2"></i>Grid
                            </button>
                            <button class="btn btn-outline-primary px-4" id="listView" style="border-radius: 0;">
                                <i class="fas fa-list me-2"></i>List
                            </button>
                        </div>
                        <button class="btn btn-lg shadow-sm" onclick="createNewForm()" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; color: white; border-radius: 12px; padding: 12px 24px;">
                            <i class="fas fa-plus me-2"></i>Create New Form
                        </button>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="row mb-5 g-4">
                    <div class="col-xl-3 col-md-6">
                        <div class="stat-card border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px;">
                            <div class="card-body p-4 text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h2 class="fw-bold mb-1">{{ $forms->count() }}</h2>
                                        <p class="mb-0 opacity-90">Total Forms</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-file-alt fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="stat-card border-0 shadow-sm" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 16px;">
                            <div class="card-body p-4 text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h2 class="fw-bold mb-1">{{ $forms->where('is_active', true)->count() }}</h2>
                                        <p class="mb-0 opacity-90">Active Forms</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-check-circle fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="stat-card border-0 shadow-sm" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 16px;">
                            <div class="card-body p-4 text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h2 class="fw-bold mb-1">{{ $forms->sum(function($form) { return $form->submissions->count(); }) }}</h2>
                                        <p class="mb-0 opacity-90">Total Submissions</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-paper-plane fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="stat-card border-0 shadow-sm" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); border-radius: 16px;">
                            <div class="card-body p-4 text-dark">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h2 class="fw-bold mb-1">{{ $forms->where('created_at', '>=', now()->subDays(7))->count() }}</h2>
                                        <p class="mb-0 opacity-75">This Week</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-calendar-week fa-2x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Forms Grid -->
                <div id="formsContainer">
                    @if($forms->count() > 0)
                        <div class="row g-4" id="formsGrid">
                            @foreach($forms as $form)
                            <div class="col-lg-4 col-md-6 mb-4 form-item" data-title="{{ strtolower($form->title) }}">
                                <div class="card form-card h-100 border-0 shadow-sm" style="border-radius: 16px; transition: all 0.3s ease;">
                                    <div class="card-header bg-transparent border-0 p-4 position-relative">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="form-icon position-relative" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-file-alt fa-2x text-white"></i>
                                                @if($form->submissions->count() > 0)
                                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" 
                                                          style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%); font-size: 0.7rem;"
                                                          data-bs-toggle="tooltip" 
                                                          title="{{ $form->submissions->count() }} new submissions">
                                                        {{ $form->submissions->count() > 99 ? '99+' : $form->submissions->count() }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                @if($form->submissions->count() > 0)
                                                    <div class="message-indicator" 
                                                         data-bs-toggle="tooltip" 
                                                         title="{{ $form->submissions->count() }} submissions received"
                                                         onclick="window.location.href='{{ route('forms.submissions', $form) }}'">
                                                        <i class="fas fa-envelope text-success" style="font-size: 1.2rem;"></i>
                                                        <span class="badge bg-success rounded-pill ms-1">{{ $form->submissions->count() }}</span>
                                                    </div>
                                                @endif
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-light dropdown-toggle shadow-sm" data-bs-toggle="dropdown" style="border-radius: 8px; border: none;">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu shadow border-0" style="border-radius: 12px;">
                                                        <li><a class="dropdown-item py-2" href="{{ route('forms.edit', $form) }}">
                                                            <i class="fas fa-edit me-2 text-primary"></i>Edit
                                                        </a></li>
                                                        <li><a class="dropdown-item py-2" href="{{ route('forms.show', $form) }}">
                                                            <i class="fas fa-eye me-2 text-info"></i>View Submissions ({{ $form->submissions->count() }})
                                                        </a></li>
                                                        <li><a class="dropdown-item py-2" href="/admin/forms/{{ $form->id }}/enhanced-builder">
                                                            <i class="fas fa-magic me-2 text-success"></i>Advanced Edit
                                                        </a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item py-2 text-danger" href="#" onclick="deleteForm({{ $form->id }})">
                                                            <i class="fas fa-trash me-2"></i>Delete
                                                        </a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-4 pt-0">
                                        <h6 class="card-title fw-bold mb-2">{{ $form->title }}</h6>
                                        <p class="card-text text-muted small mb-3">{{ Str::limit($form->description, 60) }}</p>

                                        <div class="form-stats mb-3">
                                            <div class="d-flex justify-content-between text-center">
                                                <div class="stat-item flex-fill">
                                                    <div class="fw-bold text-primary fs-5">{{ count($form->fields ?? []) }}</div>
                                                    <small class="text-muted">Fields</small>
                                                </div>
                                                <div class="stat-item flex-fill border-start border-end">
                                                    <div class="fw-bold text-success fs-5">{{ $form->submissions->count() }}</div>
                                                    <small class="text-muted">Responses</small>
                                                </div>
                                                <div class="stat-item flex-fill">
                                                    <div class="fw-bold text-info fs-6">{{ $form->created_at->format('M d') }}</div>
                                                    <small class="text-muted">Created</small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- List view content -->
                                        <div class="list-content d-none w-100">
                                            <div class="d-flex align-items-center justify-content-between w-100">
                                                <div class="flex-grow-1">
                                                    <h6 class="card-title mb-1">{{ $form->title }}</h6>
                                                    <p class="card-text text-muted mb-0">{{ Str::limit($form->description, 80) }}</p>
                                                </div>
                                                <div class="d-flex align-items-center gap-4 ms-4">
                                                    <div class="text-center">
                                                        <div class="fw-bold text-primary">{{ count($form->fields ?? []) }}</div>
                                                        <small class="text-muted">Fields</small>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="fw-bold text-success">{{ $form->submissions->count() }}</div>
                                                        <small class="text-muted">Responses</small>
                                                    </div>
                                                    <span class="badge px-3 py-2" style="background: {{ $form->is_active ? 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)' : '#6c757d' }}; border-radius: 20px; font-size: 0.75rem;">
                                                        {{ $form->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                    <div class="form-actions d-flex gap-2 ms-3">
                                                        <a href="{{ route('forms.edit', $form) }}" class="btn btn-sm shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; padding: 8px 12px;">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="{{ route('forms.show', $form) }}" class="btn btn-sm btn-light shadow-sm" style="border-radius: 8px; padding: 8px 12px;">
                                                            <i class="fas fa-eye text-info"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge px-3 py-2" style="background: {{ $form->is_active ? 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)' : '#6c757d' }}; border-radius: 20px; font-size: 0.75rem;">
                                                {{ $form->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                            <div class="form-actions d-flex gap-2">
                                                <a href="{{ route('forms.edit', $form) }}" class="btn btn-sm shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; padding: 8px 12px;">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('forms.show', $form) }}" class="btn btn-sm btn-light shadow-sm" style="border-radius: 8px; padding: 8px 12px;">
                                                    <i class="fas fa-eye text-info"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted mb-3">No forms yet</h4>
                                <p class="text-muted mb-4">Create your first form to get started</p>
                                <button class="btn btn-primary btn-lg" onclick="createNewForm()">
                                    <i class="fas fa-plus me-2"></i>Create Your First Form
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                @if($forms->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $forms->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    // Initialize tooltips
    $(document).ready(function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    // Create new form
    function createNewForm() {
        window.location.href = '{{ route("forms.create") }}';
    }

    // Delete form
    function deleteForm(id) {
        if(confirm('Are you sure you want to delete this form?')) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: `/admin/forms/${id}`,
                method: 'DELETE',
                success: function() {
                    location.reload();
                },
                error: function() {
                    alert('Error deleting form');
                }
            });
        }
    }

    // Search forms
    $('#searchForms').on('input', function() {
        const query = $(this).val().toLowerCase();
        $('.form-item').each(function() {
            const title = $(this).data('title');
            $(this).toggle(title.includes(query));
        });
    });

    // View toggle
    $('#gridView').click(function() {
        $(this).addClass('active');
        $('#listView').removeClass('active');
        $('#formsGrid').removeClass('list-view');
        $('.form-item').removeClass('list-item');
        $('.form-stats').removeClass('d-none');
        $('.list-content').addClass('d-none');
        $('.card-body > h6, .card-body > p, .card-body > .d-flex:last-child').removeClass('d-none');
    });

    $('#listView').click(function() {
        $(this).addClass('active');
        $('#gridView').removeClass('active');
        $('#formsGrid').addClass('list-view');
        $('.form-item').addClass('list-item');
        $('.form-stats').addClass('d-none');
        $('.list-content').removeClass('d-none');
        $('.card-body > h6, .card-body > p, .card-body > .d-flex:last-child').addClass('d-none');
    });
    </script>

    <style>
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .sidebar-nav .nav-link {
        color: #6c757d;
        border-radius: 12px;
        margin-bottom: 8px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .sidebar-nav .nav-link:hover {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        color: #667eea;
        transform: translateX(4px);
    }

    .sidebar-nav .nav-link.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .nav-icon {
        width: 20px;
        text-align: center;
    }

    .form-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
        overflow: hidden;
    }

    .form-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15) !important;
    }

    .stat-card {
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.15) !important;
    }

    .stat-item {
        padding: 16px 12px;
        position: relative;
    }

    .form-stats {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 12px;
        padding: 20px 16px;
        border: 1px solid rgba(102, 126, 234, 0.1);
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .stat-item .border-start {
        border-color: rgba(102, 126, 234, 0.2) !important;
    }

    .stat-item .border-end {
        border-color: rgba(102, 126, 234, 0.2) !important;
    }

    .empty-state {
        max-width: 500px;
        margin: 0 auto;
        padding: 60px 20px;
    }

    .search-container input:focus {
        border-color: #667eea !important;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1) !important;
        background: white !important;
    }

    .btn-group .btn.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        border-color: #667eea !important;
        color: white !important;
    }

    .list-item {
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }

    .list-item .form-card {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        min-height: 120px !important;
        max-height: 120px !important;
    }

    .list-item .card-header {
        flex: 0 0 auto !important;
        width: 120px !important;
        padding: 1rem !important;
    }

    .list-item .card-body {
        flex: 1 !important;
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 1rem !important;
    }

    .list-item .card-body > .d-flex:last-child {
        display: none !important;
    }

    .list-item .list-content {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        width: 100% !important;
        padding: 0 !important;
    }

    .list-item .form-actions {
        flex-shrink: 0 !important;
    }

    .list-item .card-body {
        display: flex !important;
        align-items: center !important;
        width: 100% !important;
    }

    @media (max-width: 768px) {
        .search-container input {
            width: 250px !important;
        }

        .sidebar-nav {
            display: none;
        }

        .stat-card .card-body {
            padding: 1.5rem !important;
        }
    }

    @media (max-width: 576px) {
        .search-container input {
            width: 200px !important;
        }

        .navbar-brand {
            font-size: 1.3rem !important;
        }
    }

    .fade-in {
        animation: fadeIn 0.6s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .message-indicator {
        display: flex;
        align-items: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .message-indicator:hover {
        transform: scale(1.1);
    }

    .badge.rounded-pill {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    </style>
</body>
</html>
