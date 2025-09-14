@extends('admin.main.app')
@section('content')

    <div class="card">
        {{-- Page Header --}}
        <x-ui.page-header :backRoute="route('permission.index')" :title="isset($data['record']->id) ? 'Edit Permission' : 'Create Permission'" />

        {{-- Form Section --}}
        <div class="card-body">
            @include('UserManagement::permission.partial._form')
        </div>

    </div>
@endsection
