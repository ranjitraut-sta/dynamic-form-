@extends('admin.main.app')
@section('content')
    <div class="card shadow-sm rounded-2">
        {{-- Page Header --}}
        <x-ui.page-header :backRoute="route('role.index')" :title="isset($data['record']->id) ? 'Edit Role' : 'Create Role'" />

        <div class="card-body">
            {{-- Form --}}
            @include('UserManagement::role.partial._form')
        </div>
    </div>

@endsection
