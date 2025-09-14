@extends('admin.main.app')
@section('content')
<div class="row">
    <div class="col-xl-12 mx-auto">
        <form action="{{ route('role.permission.store') }}" method="POST">
            @csrf
            <input type="hidden" name="role_id" value="{{ $data['RoleId'] }}">

            <div class="card permission-card shadow-lg">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-0 text-white">Manage Permissions for Role : <span class="badge bg-light text-primary fs-5 mt-1">{{ $data['getRollName'] }}</span></h4>
                    </div>
                    <a href="{{ route('role.index') }}" class="btn btn-outline-light">
                        <i class="fa-solid fa-angles-left"></i> Back
                    </a>
                </div>

                <div class="card-body">
                    {{-- Master Controls & Search --}}
                    <div class="master-controls mb-4">
                        <div class="row gy-3 align-items-center">
                            <div class="col-md-6">
                                <div class="form-check form-switch form-check-lg">
                                    <input class="form-check-input" type="checkbox" id="masterSelectAll">
                                    <label class="form-check-label h6 mb-0" for="masterSelectAll">Select / Deselect All</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <input type="text" id="permissionSearch" class="form-control" placeholder="Search for a permission...">
                            </div>
                        </div>
                    </div>

                    {{-- Permissions Accordion --}}
                    <div class="accordion permission-accordion" id="permissionsAccordion">
                        @foreach ($data['permissions'] as $groupname => $permissionGroup)
                            @php
                                $groupSlug = \Illuminate\Support\Str::slug($groupname);
                            @endphp
                            <div class="accordion-item" data-group-container>
                                <h2 class="accordion-header" id="heading-{{ $groupSlug }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $groupSlug }}">
                                        {{ $groupname }}
                                        <span class="badge rounded-pill bg-secondary permission-count-badge" id="badge-{{ $groupSlug }}"></span>
                                    </button>
                                </h2>
                                <div id="collapse-{{ $groupSlug }}" class="accordion-collapse collapse" data-bs-parent="#permissionsAccordion">
                                    <div class="accordion-body">
                                        <div class="mb-3 border-bottom pb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input group-select-all" type="checkbox" id="select-group-{{ $groupSlug }}" data-group-slug="{{ $groupSlug }}">
                                                <label class="form-check-label fw-bold" for="select-group-{{ $groupSlug }}">Select All in this Group</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            @foreach ($permissionGroup as $permission)
                                                <div class="col-md-4 permission-item" data-permission-name="{{ strtolower($permission->name) }}">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input permission-checkbox" type="checkbox" name="permission_id[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}" data-group-slug="{{ $groupSlug }}" @if (in_array($permission->id, $data['roleHasPermissions'])) checked @endif>
                                                        <label class="form-check-label" for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card-footer text-center sticky-footer">
                     <x-form.submit-button :label="'Save & Assign Permissions'" />
                </div>
            </div>
        </form>
    </div>
</div>
@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const masterSelectAll = document.getElementById('masterSelectAll');
    const groupSelectAlls = document.querySelectorAll('.group-select-all');
    const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');
    const searchInput = document.getElementById('permissionSearch');

    // --- State & Count Update Functions ---

    function updateGroupStateAndCount(groupSlug) {
        const groupCheckbox = document.getElementById(`select-group-${groupSlug}`);
        const groupBadge = document.getElementById(`badge-${groupSlug}`);
        if (!groupCheckbox) return;

        const childCheckboxes = document.querySelectorAll(`.permission-checkbox[data-group-slug="${groupSlug}"]`);
        const total = childCheckboxes.length;
        const checkedCount = Array.from(childCheckboxes).filter(cb => cb.checked).length;

        groupBadge.textContent = `${checkedCount} / ${total}`;

        if (checkedCount === 0) {
            groupCheckbox.checked = false;
            groupCheckbox.indeterminate = false;
        } else if (checkedCount === total) {
            groupCheckbox.checked = true;
            groupCheckbox.indeterminate = false;
        } else {
            groupCheckbox.checked = false;
            groupCheckbox.indeterminate = true;
        }
    }

    function updateMasterSelectAllState() {
        const total = permissionCheckboxes.length;
        const checkedCount = Array.from(permissionCheckboxes).filter(cb => cb.checked).length;

        if (checkedCount === 0) {
            masterSelectAll.checked = false;
            masterSelectAll.indeterminate = false;
        } else if (checkedCount === total) {
            masterSelectAll.checked = true;
            masterSelectAll.indeterminate = false;
        } else {
            masterSelectAll.checked = false;
            masterSelectAll.indeterminate = true;
        }
    }

    // --- Event Listeners ---

    masterSelectAll.addEventListener('change', function () {
        permissionCheckboxes.forEach(cb => cb.checked = this.checked);
        groupSelectAlls.forEach(groupCheckbox => {
            groupCheckbox.checked = this.checked;
            groupCheckbox.indeterminate = false;
            updateGroupStateAndCount(groupCheckbox.dataset.groupSlug);
        });
    });

    groupSelectAlls.forEach(groupCheckbox => {
        groupCheckbox.addEventListener('change', function () {
            const groupSlug = this.dataset.groupSlug;
            const childCheckboxes = document.querySelectorAll(`.permission-checkbox[data-group-slug="${groupSlug}"]`);
            childCheckboxes.forEach(cb => cb.checked = this.checked);
            updateMasterSelectAllState();
        });
    });

    permissionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const groupSlug = this.dataset.groupSlug;
            updateGroupStateAndCount(groupSlug);
            updateMasterSelectAllState();
        });
    });

    // --- Search Functionality ---
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        const allPermissionItems = document.querySelectorAll('.permission-item');
        const allGroupContainers = document.querySelectorAll('[data-group-container]');

        allPermissionItems.forEach(item => {
            const name = item.dataset.permissionName;
            const isVisible = name.includes(searchTerm);
            item.style.display = isVisible ? '' : 'none';
        });

        allGroupContainers.forEach(container => {
            const visibleItemsInGroup = container.querySelectorAll('.permission-item[style*="display: none;"]');
            const totalItemsInGroup = container.querySelectorAll('.permission-item');
            const shouldGroupBeVisible = visibleItemsInGroup.length < totalItemsInGroup.length;
            container.style.display = shouldGroupBeVisible ? '' : 'none';
        });
    });

    // --- Initial State on Page Load ---
    groupSelectAlls.forEach(groupCheckbox => {
        updateGroupStateAndCount(groupCheckbox.dataset.groupSlug);
    });
    updateMasterSelectAllState();
});
</script>
@endpush
