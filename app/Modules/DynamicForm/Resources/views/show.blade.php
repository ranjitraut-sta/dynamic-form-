@extends('admin.main.app')
@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center text-white">
                        <div>
                            <h2 class="mb-2 font-weight-bold text-white">{{ $form->title }}</h2>
                            <p class="mb-0 opacity-90">{{ $form->description }}</p>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <div class="dropdown">
                                <button class="btn btn-light btn-lg dropdown-toggle shadow-sm" type="button" id="shareDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 12px;">
                                    <i class="fas fa-share-alt me-2"></i>Share Form
                                </button>
                                <ul class="dropdown-menu shadow border-0" aria-labelledby="shareDropdown" style="border-radius: 12px;">
                                    <li><a class="dropdown-item py-2" href="{{ route('form.public.url', $form->unique_url) }}" target="_blank">
                                        <i class="fas fa-external-link-alt text-primary me-2"></i>Open Public Link
                                    </a></li>
                                    <li><a class="dropdown-item py-2" href="#" onclick="copyToClipboard('{{ url('f/' . $form->unique_url) }}')">
                                        <i class="fas fa-copy text-success me-2"></i>Copy Link
                                    </a></li>
                                </ul>
                            </div>
                            <a href="{{ route('forms.edit', $form) }}" class="btn btn-warning btn-lg shadow-sm" style="border-radius: 12px;">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <a href="{{ route('forms.index') }}" class="btn btn-outline-light btn-lg shadow-sm" style="border-radius: 12px;">
                                <i class="fas fa-arrow-left me-2"></i>Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white text-center p-4">
                    <div class="display-4 mb-2">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3 class="mb-1">{{ $form->submissions->count() }}</h3>
                    <p class="mb-0 opacity-90">Total Submissions</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="card-body text-white text-center p-4">
                    <div class="display-4 mb-2">
                        <i class="fas fa-list-ul"></i>
                    </div>
                    <h3 class="mb-1">{{ count($form->fields ?? []) }}</h3>
                    <p class="mb-0 opacity-90">Form Fields</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="card-body text-white text-center p-4">
                    <div class="display-4 mb-2">
                        <i class="fas fa-{{ $form->is_active ? 'check-circle' : 'pause-circle' }}"></i>
                    </div>
                    <h5 class="mb-1">{{ $form->is_active ? 'Active' : 'Inactive' }}</h5>
                    <p class="mb-0 opacity-90">Form Status</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <div class="card-body text-white text-center p-4">
                    <div class="display-4 mb-2">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h6 class="mb-1">{{ $form->created_at->format('M d, Y') }}</h6>
                    <p class="mb-0 opacity-90">Created Date</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                <div class="card-body p-0">
                    <div class="tab-content" id="formTabsContent">
                        <!-- Form Details Tab -->
                            <div class="p-4">
                                <div class="row">
                                    <!-- Form Preview -->
                                    <div class="col-lg-8 mb-4">
                                        <h5 class="mb-3 font-weight-bold">
                                            <i class="fas fa-desktop text-primary me-2"></i>Form Preview
                                        </h5>
                                        <div class="form-preview-container p-4" style="background: #f8f9ff; border-radius: 16px; border: 2px dashed #e3e8ff;">
                                            <form>
                                                @foreach($form->fields ?? [] as $field)
                                                <div class="mb-4">
                                                    <label class="form-label font-weight-semibold mb-2">
                                                        {{ $field['label'] }}
                                                        @if($field['required'] ?? false)
                                                            <span class="text-danger ms-1">*</span>
                                                        @endif
                                                    </label>

                                                    @switch($field['type'])
                                                        @case('textarea')
                                                            <textarea class="form-control form-control-lg" placeholder="{{ $field['placeholder'] ?? 'Enter ' . strtolower($field['label']) }}" rows="4" disabled style="border-radius: 12px; border: 2px solid #e3e8ff;"></textarea>
                                                            @break
                                                        @case('select')
                                                            <select class="form-control form-control-lg" disabled style="border-radius: 12px; border: 2px solid #e3e8ff;">
                                                                <option>Choose an option...</option>
                                                                @if(isset($field['options']))
                                                                    @foreach($field['options'] as $option)
                                                                        <option>{{ $option }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            @break
                                                        @case('radio')
                                                            @if(isset($field['options']))
                                                                <div class="options-container">
                                                                    @foreach($field['options'] as $option)
                                                                        <div class="form-check form-check-inline me-4">
                                                                            <input class="form-check-input" type="radio" disabled style="transform: scale(1.2);">
                                                                            <label class="form-check-label ms-2">{{ $option }}</label>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                            @break
                                                        @case('checkbox')
                                                            @if(isset($field['options']))
                                                                <div class="options-container">
                                                                    @foreach($field['options'] as $option)
                                                                        <div class="form-check mb-2">
                                                                            <input class="form-check-input" type="checkbox" disabled style="transform: scale(1.2);">
                                                                            <label class="form-check-label ms-2">{{ $option }}</label>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                            @break
                                                        @case('date')
                                                            <input type="date" class="form-control form-control-lg" disabled style="border-radius: 12px; border: 2px solid #e3e8ff;">
                                                            @break
                                                        @case('file')
                                                            <div class="file-upload-preview p-4 text-center" style="border: 2px dashed #667eea; border-radius: 12px; background: #f8f9ff;">
                                                                <i class="fas fa-cloud-upload-alt text-primary display-5 mb-2"></i>
                                                                <p class="mb-0 text-muted">Drag & drop files here or click to browse</p>
                                                            </div>
                                                            @break
                                                        @default
                                                            <input type="{{ $field['type'] }}" class="form-control form-control-lg" placeholder="{{ $field['placeholder'] ?? 'Enter ' . strtolower($field['label']) }}" disabled style="border-radius: 12px; border: 2px solid #e3e8ff;">
                                                    @endswitch
                                                </div>
                                                @endforeach
                                                <div class="text-center mt-4">
                                                    <button type="button" class="btn btn-primary btn-lg px-5" disabled style="border-radius: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                                                        <i class="fas fa-paper-plane me-2"></i>Submit Form
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Form Configuration -->
                                    <div class="col-lg-4 mb-4">
                                        <h5 class="mb-3 font-weight-bold">
                                            <i class="fas fa-cog text-warning me-2"></i>Configuration
                                        </h5>
                                        <div class="config-item d-flex justify-content-between align-items-center mb-3 p-3" style="background: #f8f9ff; border-radius: 12px;">
                                            <span class="font-weight-semibold">Status</span>
                                            <span class="badge badge-pill px-3 py-2 {{ $form->is_active ? 'badge-success' : 'badge-danger' }}" style="font-size: 0.85rem;">
                                                <i class="fas fa-{{ $form->is_active ? 'check' : 'times' }} me-1"></i>
                                                {{ $form->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                        <div class="config-item d-flex justify-content-between align-items-center mb-3 p-3" style="background: #f8f9ff; border-radius: 12px;">
                                            <span class="font-weight-semibold">Created</span>
                                            <span class="text-muted">{{ $form->created_at->format('M d, Y') }}</span>
                                        </div>
                                        <div class="config-item d-flex justify-content-between align-items-center p-3" style="background: #f8f9ff; border-radius: 12px;">
                                            <span class="font-weight-semibold">Last Updated</span>
                                            <span class="text-muted">{{ $form->updated_at->format('M d, Y') }}</span>
                                        </div>

                                        <h5 class="mb-3 font-weight-bold mt-4">
                                            <i class="fas fa-list text-info me-2"></i>Form Fields
                                        </h5>
                                        <div class="fields-list">
                                            @foreach($form->fields ?? [] as $index => $field)
                                            <div class="field-item d-flex align-items-center mb-3 p-3" style="background: #f8f9ff; border-radius: 12px; transition: all 0.3s ease;">
                                                <div class="field-icon me-3">
                                                    <div class="icon-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; color: white; font-size: 14px; font-weight: bold;">
                                                        {{ $index + 1 }}
                                                    </div>
                                                </div>
                                                <div class="field-info flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="font-weight-semibold">{{ $field['label'] }}</span>
                                                        @if($field['required'] ?? false)
                                                            <span class="text-danger ms-2">
                                                                <i class="fas fa-asterisk" style="font-size: 10px;"></i>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center mt-1">
                                                        <small class="text-muted">{{ $field['placeholder'] ?? 'No placeholder' }}</small>
                                                        <span class="badge badge-secondary badge-pill">{{ ucfirst($field['type']) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Submission View Modal -->
<div class="modal fade" id="submissionModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 p-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px 20px 0 0;">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-file-alt me-2"></i>Submission Details
                </h5>
                <button type="button" class="btn btn-link text-white p-0" data-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body p-4" id="submissionContent">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer border-0 p-4">
                <button type="button" class="btn btn-outline-secondary btn-lg" data-dismiss="modal" style="border-radius: 12px;">
                    <i class="fas fa-times me-2"></i>Close
                </button>
                <button type="button" class="btn btn-primary btn-lg" id="exportSubmission" style="border-radius: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                    <i class="fas fa-download me-2"></i>Export
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.nav-tabs .nav-link {
    border: none;
    color: #6c757d;
    font-weight: 500;
    padding: 12px 24px;
    margin-right: 8px;
    transition: all 0.3s ease;
}

.nav-tabs .nav-link.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px 12px 0 0 !important;
}

.nav-tabs .nav-link:hover {
    border: none;
    background: #f8f9ff;
    color: #667eea;
}

.form-control:focus {
    border-color: #667eea !important;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25) !important;
}

.field-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
}

.table tbody tr:hover {
    background-color: #f8f9ff !important;
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.card {
    transition: all 0.3s ease;
}

.success-animation {
    animation: bounceIn 0.6s ease;
}

@keyframes bounceIn {
    0% { transform: scale(0.3); opacity: 0; }
    50% { transform: scale(1.05); }
    70% { transform: scale(0.9); }
    100% { transform: scale(1); opacity: 1; }
}

.toast-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 20px;
    border-radius: 12px;
    color: white;
    font-weight: 500;
    z-index: 9999;
    max-width: 350px;
}

.toast-success {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    box-shadow: 0 4px 12px rgba(67, 233, 123, 0.3);
}

.toast-error {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
    box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
}
</style>

@endsection
@push('scripts')
<script>
$(document).ready(function() {
    let currentSubmissionData = null;

    // View submission
    $(document).on('click', '.view-submission', function() {
        const id = $(this).data('id');
        const data = $(this).data('submission');
        currentSubmissionData = data;

        let content = '<div class="submission-details">';

        // Header with ID and date
        content += '<div class="row mb-4">';
        content += '<div class="col-md-6">';
        content += '<div class="info-card p-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; color: white;">';
        content += '<h6 class="mb-1"><i class="fas fa-hashtag me-2"></i>Submission ID</h6>';
        content += '<h4 class="mb-0">#' + id + '</h4>';
        content += '</div>';
        content += '</div>';
        content += '<div class="col-md-6">';
        content += '<div class="info-card p-3" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 12px; color: white;">';
        content += '<h6 class="mb-1"><i class="fas fa-calendar-alt me-2"></i>Submitted Date</h6>';
        content += '<h5 class="mb-0">' + new Date().toLocaleDateString() + '</h5>';
        content += '</div>';
        content += '</div>';
        content += '</div>';

        // Form data
        content += '<h6 class="mb-3 font-weight-bold"><i class="fas fa-database me-2 text-primary"></i>Form Data</h6>';
        content += '<div class="row">';

        @foreach($form->fields ?? [] as $field)
            const fieldName_{{ $loop->index }} = '{{ $field["name"] ?? $field["id"] }}';
            const fieldLabel_{{ $loop->index }} = '{{ $field["label"] }}';
            let fieldValue_{{ $loop->index }} = data[fieldName_{{ $loop->index }}] || 'No data provided';

            if (Array.isArray(fieldValue_{{ $loop->index }})) {
                fieldValue_{{ $loop->index }} = fieldValue_{{ $loop->index }}.join(', ');
            }

            content += '<div class="col-md-6 mb-3">';
            content += '<div class="data-card p-3 h-100" style="background: #f8f9ff; border: 1px solid #e3e8ff; border-radius: 12px;">';
            content += '<h6 class="text-primary mb-2"><i class="fas fa-tag me-2"></i>' + fieldLabel_{{ $loop->index }} + '</h6>';
            content += '<p class="mb-0 text-dark font-weight-medium">' + (fieldValue_{{ $loop->index }} || '<em class="text-muted">No data</em>') + '</p>';
            content += '</div>';
            content += '</div>';
        @endforeach

        content += '</div>';
        content += '</div>';

        $('#submissionContent').html(content);
        $('#submissionModal').modal('show');
    });

    // Delete submission
    $(document).on('click', '.delete-submission', function() {
        const id = $(this).data('id');
        const btn = $(this);

        if (confirm('⚠️ Are you sure you want to delete this submission?\n\nThis action cannot be undone.')) {
            const originalHTML = btn.html();
            btn.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);

            $.ajax({
                url: `/admin/forms/{{ $form->id }}/submissions/${id}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        btn.html('<i class="fas fa-check"></i>')
                           .removeClass('btn-outline-danger')
                           .addClass('btn-success');

                        setTimeout(function() {
                            showToast('Submission deleted successfully!', 'success');
                            location.reload();
                        }, 1000);
                    } else {
                        showToast('Error deleting submission', 'error');
                        btn.html(originalHTML).prop('disabled', false);
                    }
                },
                error: function() {
                    showToast('Error deleting submission', 'error');
                    btn.html(originalHTML).prop('disabled', false);
                }
            });
        }
    });

    // Export submission
    $('#exportSubmission').click(function() {
        if (!currentSubmissionData) return;

        let csvContent = 'Field,Value\n';

        @foreach($form->fields ?? [] as $field)
            const fieldName_exp_{{ $loop->index }} = '{{ $field["name"] ?? $field["id"] }}';
            const fieldLabel_exp_{{ $loop->index }} = '{{ $field["label"] }}';
            let fieldValue_exp_{{ $loop->index }} = currentSubmissionData[fieldName_exp_{{ $loop->index }}] || '';

            if (Array.isArray(fieldValue_exp_{{ $loop->index }})) {
                fieldValue_exp_{{ $loop->index }} = fieldValue_exp_{{ $loop->index }}.join('; ');
            }

            fieldValue_exp_{{ $loop->index }} = fieldValue_exp_{{ $loop->index }}.toString().replace(/"/g, '""');
            csvContent += `"${fieldLabel_exp_{{ $loop->index }}}","${fieldValue_exp_{{ $loop->index }}}"\n`;
        @endforeach

        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);

        link.setAttribute('href', url);
        link.setAttribute('download', `submission_${new Date().getTime()}.csv`);
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        showToast('Submission exported successfully!', 'success');
    });

    // Copy to clipboard
    window.copyToClipboard = function(text) {
        navigator.clipboard.writeText(text).then(function() {
            showToast('Link copied to clipboard!', 'success');
        }, function() {
            showToast('Failed to copy link', 'error');
        });
    };

    // Toast notification function
    function showToast(message, type) {
        const toast = $('<div class="toast-notification success-animation toast-' + type + '">')
            .html('<div class="d-flex align-items-center"><i class="fas fa-' + (type === 'success' ? 'check-circle' : 'exclamation-circle') + ' me-2"></i><span>' + message + '</span></div>');

        $('body').append(toast);

        setTimeout(function() {
            toast.css({
                'transform': 'translateX(400px)',
                'opacity': '0',
                'transition': 'all 0.3s ease'
            });
            setTimeout(function() {
                toast.remove();
            }, 300);
        }, 3000);
    }
});
</script>
@endpush
