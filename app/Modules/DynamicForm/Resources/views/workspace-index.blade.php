<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Forms - Workspace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <!-- Top Navigation with Glassmorphism -->
    <nav class="navbar navbar-expand-lg fixed-top glass-nav">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold gradient-text" href="{{ route('adminLayout') }}" style="font-size: 1.8rem;">
                Dashboard
            </a>

            <!-- Search Bar -->
            <div class="search-wrapper d-none d-md-flex">
                <div class="search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="form-control search-input" id="searchForms" placeholder="Search forms...">
                    <div class="search-suggestions" id="searchSuggestions"></div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid dashboard-container">
        <div class="row">
            <!-- Enhanced Sidebar -->
            <div class="col-xl-3 col-lg-3 d-none d-lg-block sidebar-wrapper">
                <div class="sidebar-nav">
                    <div class="sidebar-content">
                        <h6 class="sidebar-title">Workspace</h6>
                        <ul class="nav-list">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">
                                    <div class="nav-icon-wrapper">
                                        <i class="fas fa-file-alt nav-icon"></i>
                                    </div>
                                    <span class="nav-text">My Forms</span>
                                    <div class="nav-indicator"></div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <div class="nav-icon-wrapper">
                                        <i class="fas fa-chart-line nav-icon"></i>
                                    </div>
                                    <span class="nav-text">Analytics</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <div class="nav-icon-wrapper">
                                        <i class="fas fa-layer-group nav-icon"></i>
                                    </div>
                                    <span class="nav-text">Templates</span>
                                    <span class="nav-badge">New</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <div class="nav-icon-wrapper">
                                        <i class="fas fa-users nav-icon"></i>
                                    </div>
                                    <span class="nav-text">Team</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <div class="nav-icon-wrapper">
                                        <i class="fas fa-trash-alt nav-icon"></i>
                                    </div>
                                    <span class="nav-text">Trash</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Storage Indicator -->
                        <div class="storage-widget">
                            <div class="storage-header">
                                <span class="storage-title">Storage Used</span>
                                <span class="storage-info">2.5 GB / 10 GB</span>
                            </div>
                            <div class="storage-bar">
                                <div class="storage-fill" style="width: 25%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-xl-9 col-lg-9 col-12 main-content">
                <!-- Header Section -->
                <div class="content-header">
                    <div class="header-left">
                        <h1 class="page-title">My Forms</h1>
                        <p class="page-subtitle">Create and manage your forms with ease</p>
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('adminLayout') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">My Forms</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="header-actions">
                        <div class="view-toggle">
                            <button class="toggle-btn active" id="gridView">
                                <i class="fas fa-th-large"></i>
                            </button>
                            <button class="toggle-btn" id="listView">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                        <button class="btn-primary-gradient" onclick="createNewForm()">
                            <div class="btn-content">
                                <i class="fas fa-plus"></i>
                                <span>Create Form</span>
                            </div>
                            <div class="btn-glow"></div>
                        </button>
                    </div>
                </div>

                <!-- Enhanced Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card primary">
                        <div class="stat-content">
                            <div class="stat-info">
                                <h3 class="stat-number">{{ $forms->total() }}</h3>
                                <p class="stat-label">Total Forms</p>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                        </div>
                        <div class="stat-trend">
                            <i class="fas fa-arrow-up"></i>
                            <span>+{{ rand(5, 15) }}%</span>
                        </div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-content">
                            <div class="stat-info">
                                <h3 class="stat-number">{{ $forms->where('is_active', true)->count() }}</h3>
                                <p class="stat-label">Active Forms</p>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="stat-trend">
                            <i class="fas fa-arrow-up"></i>
                            <span>+{{ rand(3, 12) }}%</span>
                        </div>
                    </div>

                    <div class="stat-card warning">
                        <div class="stat-content">
                            <div class="stat-info">
                                <h3 class="stat-number">{{ $forms->sum(function($form) { return $form->submissions->count(); }) }}</h3>
                                <p class="stat-label">Total Submissions</p>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                        </div>
                        <div class="stat-trend">
                            <i class="fas fa-arrow-up"></i>
                            <span>+24%</span>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Forms Grid -->
                <div class="forms-section">
                    <div class="section-header">
                        <h2 class="section-title">Recent Forms</h2>
                        <div class="section-actions">
                            <button class="filter-btn">
                                <i class="fas fa-filter"></i>
                                Filter
                            </button>
                            <button class="sort-btn">
                                <i class="fas fa-sort"></i>
                                Sort
                            </button>
                        </div>
                    </div>

                    <div class="forms-grid" id="formsGrid">
                        @forelse($forms as $form)
                        <div class="form-card" data-title="{{ strtolower($form->title) }}">
                            <div class="card-header">
                                <div class="form-icon-wrapper">
                                    <div class="form-icon {{ ['primary', 'success', 'warning', 'info'][rand(0, 3)] }}">
                                        <i class="fas {{ ['fa-file-alt', 'fa-envelope', 'fa-poll', 'fa-user-plus', 'fa-star'][rand(0, 4)] }}"></i>
                                    </div>
                                    @if($form->submissions->count() > 0)
                                    <div class="submission-badge" onclick="window.location.href='{{ route('forms.submissions', $form) }}'" title="View {{ $form->submissions->count() }} submissions">
                                        <span>{{ $form->submissions->count() }}</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="card-menu">
                                    <button class="menu-btn">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="menu-dropdown">
                                        <a href="{{ route('forms.show', $form) }}" class="menu-item">
                                            <i class="fas fa-eye"></i>
                                            View Form
                                        </a>
                                        <a href="{{ route('forms.edit', $form) }}" class="menu-item">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>
                                        <a href="{{ url('f/' . $form->unique_url) }}" target="_blank" class="menu-item">
                                            <i class="fas fa-share"></i>
                                            Share
                                        </a>
                                        <div class="menu-divider"></div>
                                        <a href="#" class="menu-item danger" onclick="deleteForm({{ $form->id }})">
                                            <i class="fas fa-trash"></i>
                                            Delete
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <h4 class="form-title">{{ $form->title }}</h4>
                                <p class="form-description">{{ $form->description ?: 'No description provided for this form.' }}</p>

                                <div class="form-stats">
                                    <div class="stat-item">
                                        <span class="stat-value">{{ count($form->fields ?? []) }}</span>
                                        <span class="stat-label">Fields</span>
                                    </div>
                                    <div class="stat-divider"></div>
                                    <div class="stat-item" onclick="window.location.href='{{ route('forms.submissions', $form) }}'" style="cursor: pointer;" title="View submissions">
                                        <span class="stat-value">{{ $form->submissions->count() }}</span>
                                        <span class="stat-label">Responses</span>
                                    </div>
                                    <div class="stat-divider"></div>
                                    <div class="stat-item">
                                        <span class="stat-value">{{ $form->created_at->format('M d') }}</span>
                                        <span class="stat-label">Created</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted">No forms yet</h4>
                                <p class="text-muted mb-4">Create your first form to get started</p>
                                <button class="btn-primary-gradient" onclick="createNewForm()">
                                    <div class="btn-content">
                                        <i class="fas fa-plus"></i>
                                        <span>Create Your First Form</span>
                                    </div>
                                    <div class="btn-glow"></div>
                                </button>
                            </div>
                        </div>
                        @endforelse


                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Create new form functionality
        function createNewForm() {
            window.location.href = '{{ route("forms.create") }}';
        }

        // Delete form functionality
        function deleteForm(formId) {
            if (confirm('Are you sure you want to delete this form? This action cannot be undone.')) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                    alert('CSRF token not found');
                    return;
                }

                const deleteUrl = '{{ route("forms.destroy", ":id") }}'.replace(':id', formId);

                fetch(deleteUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken.content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error deleting form');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting form');
                });
            }
        }
        // Search functionality
        document.getElementById('searchForms').addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            const formCards = document.querySelectorAll('.form-card');

            formCards.forEach(card => {
                const title = card.getAttribute('data-title');
                const shouldShow = title.includes(query);
                card.style.display = shouldShow ? 'block' : 'none';
            });
        });

        // View toggle functionality
        document.getElementById('gridView').addEventListener('click', function() {
            document.getElementById('gridView').classList.add('active');
            document.getElementById('listView').classList.remove('active');
            document.getElementById('formsGrid').classList.remove('list-view');
        });

        document.getElementById('listView').addEventListener('click', function() {
            document.getElementById('listView').classList.add('active');
            document.getElementById('gridView').classList.remove('active');
            document.getElementById('formsGrid').classList.add('list-view');
        });

        // Menu dropdown functionality
        document.querySelectorAll('.menu-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const dropdown = this.nextElementSibling;

                // Close all other dropdowns
                document.querySelectorAll('.menu-dropdown').forEach(d => {
                    if (d !== dropdown) d.classList.remove('show');
                });

                dropdown.classList.toggle('show');
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function() {
            document.querySelectorAll('.menu-dropdown').forEach(dropdown => {
                dropdown.classList.remove('show');
            });
        });

        // Animate cards on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.form-card, .stat-card').forEach(card => {
            observer.observe(card);
        });

        // Initialize tooltips for better UX
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
            new bootstrap.Tooltip(el);
        });
    </script>

    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #8b5cf6;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
            --dark: #1f2937;
            --light: #f8fafc;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;

            --gradient-primary: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            --gradient-success: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --gradient-warning: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --gradient-info: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);

            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);

            --border-radius: 12px;
            --border-radius-lg: 16px;
            --border-radius-xl: 20px;

            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: var(--gray-800);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Glass Navigation */
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none !important;
        }

        .gradient-text {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Enhanced Search */
        .search-wrapper {
            position: relative;
            max-width: 400px;
            width: 100%;
        }

        .search-container {
            position: relative;
        }

        .search-input {
            padding: 12px 20px 12px 50px;
            border: 2px solid transparent;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            font-size: 14px;
            transition: var(--transition);
            width: 100%;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            z-index: 2;
        }

        /* User Profile */
        .notification-bell {
            position: relative;
            cursor: pointer;
            padding: 8px;
            transition: var(--transition);
        }

        .notification-bell:hover {
            transform: scale(1.1);
        }

        .notification-count {
            position: absolute;
            top: 0;
            right: 0;
            background: var(--danger);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .status-indicator {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 12px;
            height: 12px;
            background: var(--success);
            border-radius: 50%;
            border: 2px solid white;
        }

        /* Dashboard Container */
        .dashboard-container {
            margin-top: 80px;
            min-height: calc(100vh - 80px);
        }

        /* Enhanced Sidebar */
        .sidebar-wrapper {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            position: fixed;
            height: calc(100vh - 80px);
            overflow-y: auto;
            z-index: 100;
        }

        .sidebar-content {
            padding: 2rem 1.5rem;
        }

        .sidebar-title {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--gray-500);
            margin-bottom: 1.5rem;
        }

        .nav-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-item {
            margin-bottom: 8px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: var(--border-radius);
            color: var(--gray-600);
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .nav-link:hover {
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary);
            transform: translateX(4px);
        }

        .nav-link.active {
            background: var(--gradient-primary);
            color: white;
            box-shadow: var(--shadow-md);
        }

        .nav-link.active .nav-indicator {
            opacity: 1;
        }

        .nav-icon-wrapper {
            width: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-icon {
            font-size: 16px;
        }

        .nav-text {
            flex: 1;
        }

        .nav-badge {
            background: var(--warning);
            color: white;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 8px;
        }

        .nav-indicator {
            position: absolute;
            right: 8px;
            width: 4px;
            height: 20px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 2px;
            opacity: 0;
            transition: var(--transition);
        }

        /* Storage Widget */
        .storage-widget {
            margin-top: 3rem;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.5);
            border-radius: var(--border-radius-lg);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .storage-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .storage-title {
            font-size: 12px;
            font-weight: 600;
            color: var(--gray-600);
        }

        .storage-info {
            font-size: 11px;
            color: var(--gray-500);
        }

        .storage-bar {
            height: 6px;
            background: var(--gray-200);
            border-radius: 3px;
            overflow: hidden;
        }

        .storage-fill {
            height: 100%;
            background: var(--gradient-primary);
            border-radius: 3px;
            transition: width 1s ease;
        }

        /* Main Content */
        .main-content {
            margin-left: 0;
            padding: 2rem;
        }

        @media (min-width: 992px) {
            .main-content {
                margin-left: 25%;
            }
        }

        /* Content Header */
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 3rem;
            gap: 2rem;
        }

        .header-left {
            flex: 1;
        }

        .page-title {
            font-size: 3rem;
            font-weight: 700;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }

        .page-subtitle {
            font-size: 1.2rem;
            color: var(--gray-600);
            margin-bottom: 1rem;
        }

        .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
            font-size: 14px;
        }

        .breadcrumb-item a {
            color: var(--gray-500);
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            color: var(--primary);
        }

        .breadcrumb-item.active {
            color: var(--gray-700);
        }

        /* Header Actions */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .view-toggle {
            display: flex;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            padding: 4px;
            box-shadow: var(--shadow);
        }

        .toggle-btn {
            padding: 8px 12px;
            border: none;
            background: none;
            color: var(--gray-600);
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 14px;
        }

        .toggle-btn.active {
            background: var(--primary);
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-primary-gradient {
            position: relative;
            background: var(--gradient-primary);
            border: none;
            color: white;
            padding: 12px 24px;
            border-radius: var(--border-radius);
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            overflow: hidden;
            transition: var(--transition);
            box-shadow: var(--shadow-md);
        }

        .btn-primary-gradient:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-primary-gradient:active {
            transform: translateY(0);
        }

        .btn-content {
            display: flex;
            align-items: center;
            gap: 8px;
            position: relative;
            z-index: 2;
        }

        .btn-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.3) 50%, transparent 70%);
            transform: translateX(-100%);
            transition: transform 0.6s;
        }

        .btn-primary-gradient:hover .btn-glow {
            transform: translateX(100%);
        }

        /* Enhanced Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius-lg);
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: var(--transition-slow);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-xl);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .stat-card:hover::before {
            transform: scaleX(1);
        }

        .stat-card.primary::before { background: var(--gradient-primary); }
        .stat-card.success::before { background: var(--gradient-success); }
        .stat-card.warning::before { background: var(--gradient-warning); }
        .stat-card.info::before { background: var(--gradient-info); }

        .stat-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 14px;
            color: var(--gray-600);
            font-weight: 500;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            opacity: 0.8;
        }

        .stat-card.primary .stat-icon {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
            color: var(--primary);
        }

        .stat-card.success .stat-icon {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1));
            color: var(--success);
        }

        .stat-card.warning .stat-icon {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(217, 119, 6, 0.1));
            color: var(--warning);
        }

        .stat-card.info .stat-icon {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.1), rgba(8, 145, 178, 0.1));
            color: var(--info);
        }

        .stat-trend {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--success);
            font-size: 14px;
            font-weight: 600;
        }

        /* Forms Section */
        .forms-section {
            margin-top: 2rem;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-800);
        }

        .section-actions {
            display: flex;
            gap: 1rem;
        }

        .filter-btn, .sort-btn {
            padding: 8px 16px;
            border: 1px solid var(--gray-300);
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            color: var(--gray-600);
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
            font-size: 14px;
        }

        .filter-btn:hover, .sort-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: white;
        }

        /* Enhanced Forms Grid */
        .forms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .forms-grid.list-view {
            grid-template-columns: 1fr;
        }

        .forms-grid.list-view .form-card {
            display: flex;
            flex-direction: row;
            align-items: center;
            padding: 1.5rem;
        }

        .forms-grid.list-view .card-header {
            flex: 0 0 auto;
            margin-right: 1.5rem;
            margin-bottom: 0;
        }

        .forms-grid.list-view .card-body {
            flex: 1;
            margin-bottom: 0;
        }

        .forms-grid.list-view .card-footer {
            flex: 0 0 auto;
            margin-left: 1.5rem;
        }

        /* Enhanced Form Cards */
        .form-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius-xl);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: var(--transition-slow);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            opacity: 0;
            transform: translateY(30px);
        }

        .form-card.animate-in {
            opacity: 1;
            transform: translateY(0);
        }

        .form-card:hover {
            transform: translateY(-12px) scale(1.03);
            box-shadow: var(--shadow-xl);
            border-color: rgba(99, 102, 241, 0.2);
        }

        .form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100%;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.03), rgba(139, 92, 246, 0.03));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .form-card:hover::before {
            opacity: 1;
        }

        .card-header {
            padding: 1.5rem 1.5rem 0;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .form-icon-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .form-icon {
            width: 60px;
            height: 60px;
            border-radius: var(--border-radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            position: relative;
            box-shadow: var(--shadow-md);
        }

        .form-icon.primary { background: var(--gradient-primary); }
        .form-icon.success { background: var(--gradient-success); }
        .form-icon.warning { background: var(--gradient-warning); }
        .form-icon.info { background: var(--gradient-info); }

        .submission-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--danger);
            color: white;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            box-shadow: var(--shadow);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .card-menu {
            position: relative;
        }

        .menu-btn {
            width: 32px;
            height: 32px;
            border: none;
            background: rgba(255, 255, 255, 0.8);
            color: var(--gray-600);
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .menu-btn:hover {
            background: white;
            color: var(--primary);
            box-shadow: var(--shadow);
        }

        .menu-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--gray-200);
            min-width: 180px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: var(--transition);
            z-index: 1000;
        }

        .menu-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--gray-700);
            text-decoration: none;
            font-size: 14px;
            transition: var(--transition);
        }

        .menu-item:hover {
            background: var(--gray-50);
            color: var(--primary);
        }

        .menu-item.danger {
            color: var(--danger);
        }

        .menu-item.danger:hover {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        .menu-divider {
            height: 1px;
            background: var(--gray-200);
            margin: 8px 0;
        }

        .card-body {
            padding: 0 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 0.5rem;
        }

        .form-description {
            color: var(--gray-600);
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 1.5rem;
        }

        .form-stats {
            display: flex;
            align-items: center;
            background: rgba(248, 250, 252, 0.8);
            border-radius: var(--border-radius);
            padding: 1rem;
            border: 1px solid rgba(226, 232, 240, 0.5);
        }

        .stat-item {
            text-align: center;
            flex: 1;
        }

        .stat-value {
            display: block;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 2px;
        }

        .stat-label {
            font-size: 11px;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-divider {
            width: 1px;
            height: 30px;
            background: var(--gray-300);
            margin: 0 1rem;
        }

        .card-footer {
            padding: 0 1.5rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .status-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-badge.active {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .status-badge.inactive {
            background: rgba(107, 114, 128, 0.1);
            color: var(--gray-600);
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .card-actions {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .action-btn.view {
            background: rgba(6, 182, 212, 0.1);
            color: var(--info);
        }

        .action-btn.view:hover {
            background: var(--info);
            color: white;
            transform: scale(1.1);
        }

        .action-btn.edit {
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary);
        }

        .action-btn.edit:hover {
            background: var(--primary);
            color: white;
            transform: scale(1.1);
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .forms-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
        }

        @media (max-width: 992px) {
            .sidebar-wrapper {
                display: none;
            }

            .main-content {
                margin-left: 0;
                padding: 1.5rem;
            }

            .content-header {
                flex-direction: column;
                align-items: stretch;
                gap: 1.5rem;
            }

            .header-actions {
                justify-content: space-between;
            }

            .page-title {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .dashboard-container {
                margin-top: 70px;
            }

            .main-content {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
            }

            .forms-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .search-wrapper {
                display: none !important;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .form-card {
                margin: 0 -0.5rem;
            }

            .content-header {
                margin-bottom: 2rem;
            }

            .header-actions {
                flex-direction: column;
                gap: 1rem;
            }
        }

        /* Animation Classes */
        .animate-in {
            animation: slideInUp 0.6s ease forwards;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--gray-100);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gray-400);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--gray-500);
        }

        /* Loading States */
        .loading {
            position: relative;
            overflow: hidden;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }
    </style>
</body>
</html>
