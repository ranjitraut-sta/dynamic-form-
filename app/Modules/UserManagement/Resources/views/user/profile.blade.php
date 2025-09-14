@extends('admin.main.app')
@section('content')
    {{-- Breadcrumb --}}
    <x-ui.breadcrumb :title="'Users'" :items="[
        ['label' => isset($data['record']->id) ? 'User' : 'Create User', 'url' => route('user.profile')],
        ['label' => isset($data['record']->id) ? 'Profile' : 'Create User', 'url' => '', 'active' => true],
    ]" />
    <div class="card">
        {{-- Form Section --}}
        <div class="card-body">
            <div class="p-4 border rounded">
                    @include('UserManagement::user.partial._profile_form')
            </div>
        </div>
    </div>
@endsection
