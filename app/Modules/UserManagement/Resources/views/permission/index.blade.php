@extends('admin.main.app')
@section('content')
    <div class="container-fluid px-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bolder text-dark mb-1">Permission Management</h2>
                <p class="text-muted mb-0">Manage system permissions with an interactive interface</p>
            </div>
            <a href="{{ route('permission.create') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                <i class="fas fa-plus-circle me-2"></i>Add New Permission
            </a>
        </div>

        <!-- Permissions Accordion -->
        <div class="accordion" id="permissionAccordion">
            @forelse ($data['records'] as $groupName => $permissions)
                <div class="accordion-item border-0 shadow-sm rounded-4 mb-3 wow-fade-in">
                    <h2 class="accordion-header" id="heading-{{ $loop->iteration }}">
                        <button class="accordion-button collapsed rounded-4 shadow-none py-3" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse-{{ $loop->iteration }}" aria-expanded="false"
                            aria-controls="collapse-{{ $loop->iteration }}">
                            <div class="d-flex align-items-center w-100">
                                <i class="fas fa-shield-alt fa-lg text-primary me-3"></i>
                                <span class="fw-bold fs-6 me-auto">{{ $groupName }}</span>
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                                    {{ count($permissions) }} Permissions
                                </span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapse-{{ $loop->iteration }}" class="accordion-collapse collapse"
                        aria-labelledby="heading-{{ $loop->iteration }}" data-bs-parent="#permissionAccordion">
                        <div class="accordion-body p-0">
                            <ul class="list-group list-group-flush">
                                @foreach ($permissions as $item)
                                    <li class="list-group-item permission-row py-3 px-4" id="permission-row-{{ $item->id }}">
                                        <div class="row align-items-center">
                                            <div class="col-md-4 d-flex align-items-center">
                                                <i class="fas fa-key text-muted me-3"></i>
                                                <span class="fw-semibold text-dark">{{ $item->name }}</span>
                                            </div>
                                            <div class="col-md-3">
                                                <span class="badge bg-light text-dark border px-2 py-1">
                                                    <i class="fas fa-cogs me-1 text-info"></i> {{ $item->controller }}
                                                </span>
                                            </div>
                                            <div class="col-md-3">
                                                <span class="badge bg-light text-dark border px-2 py-1">
                                                     <i class="fas fa-bolt me-1 text-success"></i> {{ $item->action }}
                                                </span>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <div class="btn-group action-buttons">
                                                    <a href="{{ route('permission.edit', $item->id) }}"
                                                       class="btn btn-sm btn-outline-secondary border-0" data-bs-toggle="tooltip" title="Edit">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    {{-- Delete form is now just a button --}}
                                                    <form action="{{ route('permission.destroy', $item->id) }}" method="POST" class="d-inline-block delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger border-0" data-bs-toggle="tooltip" title="Delete">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card text-center py-5">
                    <div class="card-body">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Permissions Found</h5>
                        <p>Click "Add New Permission" to get started.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Custom CSS for "Wow" Effect --}}
    <style>
        .accordion-button:not(.collapsed) {
            color: var(--bs-primary);
            background-color: #f0f5ff;
        }
        .accordion-button:focus {
            box-shadow: none;
        }
        .accordion-button::after {
            transition: transform 0.3s ease-in-out;
        }
        .accordion-button:not(.collapsed)::after {
            transform: rotate(-180deg);
        }
        .accordion-item {
            transition: all 0.3s ease;
        }
        .permission-row {
            transition: background-color 0.2s ease;
        }
        .permission-row:hover {
            background-color: #f8f9fa;
        }
        .action-buttons {
            opacity: 0;
            transition: opacity 0.2s ease;
        }
        .permission-row:hover .action-buttons {
            opacity: 1;
        }
        .badge {
            font-size: 0.8rem;
            font-weight: 500;
        }
        @keyframes wow-fade-in {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .wow-fade-in {
            animation: wow-fade-in 0.5s ease-out forwards;
        }
    </style>
@endsection
