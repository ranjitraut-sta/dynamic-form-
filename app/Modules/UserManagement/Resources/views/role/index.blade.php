@extends('admin.main.app')
@section('content')
    <div class="card shadow-sm border-0">
        {{-- Header Section --}}
        <x-table.top-header :title="'Role List'" :createRoute="route('role.create')" :createLabel="'Add New'" />

        <div class="card-body p-2">
            <!-- Table -->
            <div class="amd-soft-table-wrapper bulk-enabled" data-bulk-delete-url="{{ route('role.bulk.delete') }}">
                {{-- Filter --}}
                <x-table.filter :action="route('role.index')" :placeholder="'Search Roles'" />

                <table class="amd-soft-table" role="grid">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="select-all" class="form-check-input amd-colored-check primary checkedAll">
                            </th>
                            <th>S.N.</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="sortable-table" data-sort-url="{{ route('role.order') }}">
                        @foreach ($data['records'] as $item)
                            <tr data-id="{{ $item['id'] }}" data-display-order="{{ $item['display_order'] }}">
                                <td>
                                    <input type="checkbox" class="row-select form-check-input amd-colored-check primary"
                                        value="{{ $item['id'] }}">
                                </td>
                                <td class="serial-number">{{ $loop->iteration }}</td>
                                <td>{{ $item['name'] }}</td>
                                <td>
                                    <div class="btn-group pull-right">
                                        <x-table.edit-button :id="$item['id']" :route="'role.edit'" />
                                        <x-table.delete-button :id="$item['id']" :route="'role.destroy'" />

                                        {{-- Permission Button --}}
                                        <a href="{{ route('role.permission', $item['id']) }}"
                                            class="btn btn-sm btn-default">
                                            <span class="fa fa-key"></span>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <x-table.pagination :records="$data['records']" />
            </div>
        </div>
    </div>
@endsection
