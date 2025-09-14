@extends('admin.main.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>Dynamic Forms</h3>
                    <a href="{{ route('forms.create') }}" class="btn btn-primary">Create New Form</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Submissions</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($forms as $form)
                                <tr>
                                    <td>{{ $form->id }}</td>
                                    <td>{{ $form->title }}</td>
                                    <td>
                                        <span class="badge badge-{{ $form->is_active ? 'success' : 'danger' }}">
                                            {{ $form->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ $form->submissions()->count() }}</td>
                                    <td>{{ $form->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('forms.edit', $form) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="{{ route('forms.show', $form) }}" class="btn btn-sm btn-info">View</a>
                                        <button class="btn btn-sm btn-danger" onclick="deleteForm({{ $form->id }})">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $forms->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deleteForm(id) {
    if(confirm('Are you sure?')) {
        fetch(`/admin/forms/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then(() => location.reload());
    }
}
</script>
@endsection
