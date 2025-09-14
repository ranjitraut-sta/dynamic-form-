@extends('admin.main.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>Field Types Management</h3>
                    <a href="{{ route('field-types.create') }}" class="btn btn-primary">➕ Add New Field Type</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Icon</th>
                                    <th>Name</th>
                                    <th>Label</th>
                                    <th>Has Options</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fieldTypes as $fieldType)
                                <tr>
                                    <td>{{ $fieldType->id }}</td>
                                    <td><i class="{{ $fieldType->icon }}"></i></td>
                                    <td><code>{{ $fieldType->name }}</code></td>
                                    <td>{{ $fieldType->label }}</td>
                                    <td>
                                        <span class="badge badge-{{ $fieldType->has_options ? 'info' : 'secondary' }}">
                                            {{ $fieldType->has_options ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $fieldType->is_active ? 'success' : 'danger' }}">
                                            {{ $fieldType->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('field-types.edit', $fieldType) }}" class="btn btn-sm btn-warning">✏️ Edit</a>
                                        <button class="btn btn-sm btn-danger" onclick="deleteFieldType({{ $fieldType->id }})">🗑️ Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $fieldTypes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deleteFieldType(id) {
    if(confirm('Are you sure you want to delete this field type?')) {
        fetch(`/admin/field-types/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then(() => location.reload());
    }
}
</script>
@endsection