@extends('admin.main.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <h3>{{ $form->title }}</h3>
                        <p class="text-muted mb-0">{{ $form->description }}</p>
                    </div>
                    <div>
                        <div class="btn-group">
                            <a href="{{ route('form.public.url', $form->unique_url) }}" target="_blank" class="btn btn-success">
                                🔗 Public Link
                            </a>
                            <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" onclick="copyToClipboard('{{ url('f/' . $form->unique_url) }}')">📋 Copy Link</a>
                                <a class="dropdown-item" href="{{ route('form.public.url', $form->unique_url) }}" target="_blank">👁️ Preview</a>
                            </div>
                        </div>
                        <a href="{{ route('forms.edit', $form) }}" class="btn btn-warning">
                            ✏️ Edit Form
                        </a>
                        <a href="{{ route('forms.index') }}" class="btn btn-secondary">
                            ← Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Form Preview -->
                        <div class="col-md-6">
                            <h5>📋 Form Preview</h5>
                            <div class="border p-3 bg-light rounded">
                                <form>
                                    @foreach($form->fields ?? [] as $field)
                                    <div class="mb-3">
                                        <label class="form-label">
                                            <strong>{{ $field['label'] }}</strong>
                                            @if($field['required'] ?? false)
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>

                                        @switch($field['type'])
                                            @case('textarea')
                                                <textarea
                                                    class="form-control"
                                                    placeholder="{{ $field['placeholder'] ?? 'Enter ' . strtolower($field['label']) }}"
                                                    rows="3" disabled>
                                                </textarea>
                                                @break

                                            @case('select')
                                                <select class="form-control" disabled>
                                                    <option>Choose...</option>
                                                    @if(isset($field['options']))
                                                        @foreach($field['options'] as $option)
                                                            <option>{{ $option }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @break

                                            @case('radio')
                                                @if(isset($field['options']))
                                                    @foreach($field['options'] as $option)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" disabled>
                                                            <label class="form-check-label">{{ $option }}</label>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                @break

                                            @case('checkbox')
                                                @if(isset($field['options']))
                                                    @foreach($field['options'] as $option)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" disabled>
                                                            <label class="form-check-label">{{ $option }}</label>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                @break

                                            @case('date')
                                                <input type="date" class="form-control" disabled>
                                                @break

                                            @case('tel')
                                                <input
                                                    type="tel"
                                                    class="form-control"
                                                    placeholder="{{ $field['placeholder'] ?? 'Enter phone number' }}"
                                                    disabled>
                                                @break

                                            @case('email')
                                                <input
                                                    type="email"
                                                    class="form-control"
                                                    placeholder="{{ $field['placeholder'] ?? 'Enter email address' }}"
                                                    disabled>
                                                @break

                                            @case('file')
                                                <input type="file" class="form-control" disabled>
                                                @break

                                            @default
                                                <input
                                                    type="{{ $field['type'] }}"
                                                    class="form-control"
                                                    placeholder="{{ $field['placeholder'] ?? 'Enter ' . strtolower($field['label']) }}"
                                                    disabled>
                                        @endswitch
                                    </div>
                                    @endforeach

                                    <button type="button" class="btn btn-primary" disabled>Submit Form</button>
                                </form>
                            </div>
                        </div>

                        <!-- Form Stats & Info -->
                        <div class="col-md-6">
                            <h5>📊 Form Statistics</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card bg-primary text-white mb-3">
                                        <div class="card-body text-center">
                                            <h4>{{ $form->submissions->count() }}</h4>
                                            <small>Total Submissions</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-info text-white mb-3">
                                        <div class="card-body text-center">
                                            <h4>{{ count($form->fields ?? []) }}</h4>
                                            <small>Form Fields</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h6>🔧 Form Configuration</h6>
                            <ul class="list-group mb-3">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Status:</span>
                                    <span class="badge badge-{{ $form->is_active ? 'success' : 'danger' }}">
                                        {{ $form->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Created:</span>
                                    <span>{{ $form->created_at->format('M d, Y') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Last Updated:</span>
                                    <span>{{ $form->updated_at->format('M d, Y') }}</span>
                                </li>
                            </ul>

                            <h6>📝 Field List</h6>
                            <div class="list-group">
                                @foreach($form->fields ?? [] as $index => $field)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <span>
                                            <strong>{{ $index + 1 }}. {{ $field['label'] }}</strong>
                                            @if($field['required'] ?? false)
                                                <span class="text-danger">*</span>
                                            @endif
                                        </span>
                                        <span class="badge badge-secondary">{{ ucfirst($field['type']) }}</span>
                                    </div>
                                    @if($field['placeholder'] ?? false)
                                        <small class="text-muted">Placeholder: {{ $field['placeholder'] }}</small>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Submissions Table -->
    @if($submissions->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>📋 Recent Submissions</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    @foreach($form->fields ?? [] as $field)
                                        <th>{{ $field['label'] }}</th>
                                    @endforeach
                                    <th>Submitted At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($submissions as $submission)
                                <tr>
                                    <td>{{ $submission->id }}</td>
                                    @foreach($form->fields ?? [] as $field)
                                        <td>
                                            @if(isset($submission->data[$field['name']]))
                                                @if(is_array($submission->data[$field['name']]))
                                                    {{ implode(', ', $submission->data[$field['name']]) }}
                                                @else
                                                    {{ Str::limit($submission->data[$field['name']], 30) }}
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    @endforeach
                                    <td>{{ $submission->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="viewSubmission({{ $submission->id }}, {{ json_encode($submission->data) }})">
                                            👁️ View
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteSubmission({{ $submission->id }})">
                                            🗑️ Delete
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $submissions->links() }}
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Submission View Modal -->
<div class="modal fade" id="submissionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">📄 Submission Details</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="submissionContent">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="exportSubmission()">💾 Export</button>
            </div>
        </div>
    </div>
</div>

<script>
let currentSubmissionData = null;

function viewSubmission(id, data) {
    currentSubmissionData = data;
    
    let content = '<div class="submission-details">';
    content += '<div class="row mb-3">';
    content += '<div class="col-md-6"><strong>🆔 Submission ID:</strong> ' + id + '</div>';
    content += '<div class="col-md-6"><strong>📅 Submitted:</strong> ' + new Date().toLocaleString() + '</div>';
    content += '</div>';
    
    content += '<h6>📝 Form Data:</h6>';
    content += '<div class="table-responsive">';
    content += '<table class="table table-bordered">';
    content += '<thead class="thead-light"><tr><th>Field</th><th>Value</th></tr></thead>';
    content += '<tbody>';
    
    @foreach($form->fields ?? [] as $field)
        const fieldName = '{{ $field["name"] }}';
        const fieldLabel = '{{ $field["label"] }}';
        let fieldValue = data[fieldName] || '-';
        
        if (Array.isArray(fieldValue)) {
            fieldValue = fieldValue.join(', ');
        }
        
        content += '<tr>';
        content += '<td><strong>' + fieldLabel + '</strong></td>';
        content += '<td>' + fieldValue + '</td>';
        content += '</tr>';
    @endforeach
    
    content += '</tbody></table></div></div>';
    
    document.getElementById('submissionContent').innerHTML = content;
    $('#submissionModal').modal('show');
}

function deleteSubmission(id) {
    if (confirm('Are you sure you want to delete this submission?')) {
        fetch(`/admin/submissions/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Submission deleted successfully!');
                location.reload();
            } else {
                alert('Error deleting submission');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting submission');
        });
    }
}

function exportSubmission() {
    if (!currentSubmissionData) return;
    
    let csvContent = 'Field,Value\n';
    
    @foreach($form->fields ?? [] as $field)
        const fieldName = '{{ $field["name"] }}';
        const fieldLabel = '{{ $field["label"] }}';
        let fieldValue = currentSubmissionData[fieldName] || '';
        
        if (Array.isArray(fieldValue)) {
            fieldValue = fieldValue.join('; ');
        }
        
        csvContent += `"${fieldLabel}","${fieldValue}"\n`;
    @endforeach
    
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'submission.csv';
    a.click();
    window.URL.revokeObjectURL(url);
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Link copied to clipboard!');
    }, function(err) {
        console.error('Could not copy text: ', err);
    });
}
</script>
@endsection
