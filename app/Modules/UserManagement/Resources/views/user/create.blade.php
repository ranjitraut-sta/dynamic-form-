@extends('admin.main.app')
@section('content')
    {{-- Breadcrumb --}}
    <x-ui.breadcrumb :title="'Users'" :items="[
        ['label' => isset($data['record']->id) ? 'Edit User' : 'Create User', 'url' => route('user.index')],
        ['label' => isset($data['record']->id) ? 'Edit User' : 'Create User', 'url' => '', 'active' => true],
    ]" />
    <div class="card">
        {{-- Page Header --}}
        <x-ui.page-header :backRoute="route('user.index')" :title="isset($data['record']->id) ? 'Edit User' : 'Create User'" />

        {{-- Form Section --}}
        <div class="card-body">
            <div class="p-4 border rounded">
                @include('UserManagement::user.partial._form')
            </div>
        </div>
    </div>

@endsection
