@extends('admin.main.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Form Submissions</h2>
                    <p class="text-muted mb-0">{{ $form->title }} - {{ $submissions->total() }} submissions</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('forms.show', $form) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Form
                    </a>
                </div>
            </div>

            <!-- Submissions Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    @if($submissions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">ID</th>
                                        @foreach($form->fields ?? [] as $field)
                                            <th class="border-0 px-4 py-3">{{ $field['label'] }}</th>
                                        @endforeach
                                        <th class="border-0 px-4 py-3">Submitted At</th>
                                        <th class="border-0 px-4 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($submissions as $submission)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-primary">#{{ $submission->id }}</span>
                                        </td>
                                        @foreach($form->fields ?? [] as $field)
                                            <td class="px-4 py-3">
                                                @php
                                                    $fieldName = $field['name'] ?? $field['id'];
                                                @endphp
                                                @if(isset($submission->data[$fieldName]))
                                                    @if(is_array($submission->data[$fieldName]))
                                                        <span class="text-truncate d-inline-block" style="max-width: 150px;">{{ implode(', ', $submission->data[$fieldName]) }}</span>
                                                    @else
                                                        <span class="text-truncate d-inline-block" style="max-width: 150px;">{{ Str::limit($submission->data[$fieldName], 30) }}</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        @endforeach
                                        <td class="px-4 py-3">
                                            <small class="text-muted">{{ $submission->created_at->format('M d, Y H:i') }}</small>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-info view-submission"
                                                        data-id="{{ $submission->id }}"
                                                        data-submission="{{ json_encode($submission->data) }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger ms-1 delete-submission"
                                                        data-id="{{ $submission->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4">
                            {{ $submissions->links() }}
                        </div>
                    @else
                        <div class="text-center p-5">
                            <i class="fas fa-inbox display-1 text-muted mb-3"></i>
                            <h5 class="text-muted">No submissions yet</h5>
                            <p class="text-muted">Share your form to start receiving submissions.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Submission View Modal -->
<div class="modal fade" id="submissionModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Submission Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="submissionContent"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="exportSubmission">Export</button>
            </div>
        </div>
    </div>
</div>
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

        let content = '<div class="row">';

        @foreach($form->fields ?? [] as $field)
            const fieldName_{{ $loop->index }} = '{{ $field["name"] ?? $field["id"] }}';
            const fieldLabel_{{ $loop->index }} = '{{ $field["label"] }}';
            let fieldValue_{{ $loop->index }} = data[fieldName_{{ $loop->index }}] || 'No data provided';

            if (Array.isArray(fieldValue_{{ $loop->index }})) {
                fieldValue_{{ $loop->index }} = fieldValue_{{ $loop->index }}.join(', ');
            }

            content += '<div class="col-md-6 mb-3">';
            content += '<div class="card">';
            content += '<div class="card-body">';
            content += '<h6 class="card-title">' + fieldLabel_{{ $loop->index }} + '</h6>';
            content += '<p class="card-text">' + (fieldValue_{{ $loop->index }} || '<em class="text-muted">No data</em>') + '</p>';
            content += '</div>';
            content += '</div>';
            content += '</div>';
        @endforeach

        content += '</div>';
        $('#submissionContent').html(content);
        $('#submissionModal').modal('show');
    });

    // Delete submission
    $(document).on('click', '.delete-submission', function() {
        const id = $(this).data('id');

        if (confirm('Are you sure you want to delete this submission?')) {
            $.ajax({
                url: '{{ route("single.submissions.delete", ":id") }}'.replace(':id', id),
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    location.reload();
                },
                error: function() {
                    alert('Error deleting submission');
                }
            });
        }
    })
});
</script>
@endpush
