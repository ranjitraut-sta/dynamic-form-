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
                        <a href="{{ route('form.public', $form) }}" target="_blank" class="btn btn-success">
                            🔗 Public Link
                        </a>
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
                                        <button class="btn btn-sm btn-info" onclick="viewSubmission({{ $submission->id }})">
                                            👁️ View
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

<script>
function viewSubmission(id) {
    // You can implement a modal to show full submission details
    alert('View submission details for ID: ' + id);
}
</script>
@endsection