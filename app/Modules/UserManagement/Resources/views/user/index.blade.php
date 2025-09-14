@extends('admin.main.app')
@section('content')

    <div class="card shadow-sm border-0">
        {{-- Header Section --}}
        <x-table.top-header :title="'User List'" :createRoute="route('user.create')" :createLabel="'Add New'" />

        <div class="card-body">
            <!-- Bulk Actions will be dynamically created by JS -->

            <!-- Table -->
            <div class="amd-soft-table-wrapper bulk-enabled" data-bulk-delete-url="{{ route('user.bulk.delete') }}">
                {{-- Filter --}}
                <x-table.filter :action="route('user.index')" :placeholder="'Search Users'" />

                <table class="amd-soft-table" role="grid" aria-describedby="table-description">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="select-all" class="form-check-input amd-colored-check primary checkedAll">
                            </th>
                            <th>S.N.</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Last Login</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="sortable-table" data-sort-url="{{ route('user.order') }}">
                        @foreach ($data['records'] as $item)
                            <tr data-id="{{ $item['id'] }}" data-display-order="{{ $item['display_order'] ?? '' }}">
                                <td>
                                    <input type="checkbox" class="row-select form-check-input amd-colored-check primary" value="{{ $item['id'] }}">
                                </td>
                                <td class="serial-number">{{ ($data['records']->currentPage() - 1) * $data['records']->perPage() + $loop->iteration }}</td>
                                <td>{{ $item['role_name'] }}</td>
                                <td>{{ $item['email'] }}</td>
                                <td>{{ $item['last_login'] }}</td>

                                <td>
                                    {{-- Status Mark --}}
                                    <x-table.status-badge :status="$item['status']" />
                                </td>
                                <td name="bstable-actions">
                                    <div class="btn-group pull-right">
                                        {{-- Edit Button --}}
                                        <x-table.edit-button :id="$item['id']" :route="'user.edit'" />
                                        {{-- Delete Button --}}
                                        <x-table.delete-button :id="$item['id']" :route="'user.destroy'" />

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- Pagination --}}
                <x-table.pagination :records="$data['records']" />
            </div>
        </div>
    </div>
@endsection

