<?php

namespace App\Modules\UserManagement\Requests\user;


use App\Core\Request\BaseFormRequest;
use Illuminate\Validation\Rule;

class CreateUpdate extends BaseFormRequest
{
    protected $tempImageFields = ['profile_image'];
    protected function getCreateRules(): array
    {
        return [
            'name' => [
                'required',
                'regex:/^\S*$/',
                'unique:users,name',
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'confirmed',
                'min:6',
            ],
            'role_id' => 'required',
            'status' => 'required',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // New rule for profile_image
        ];
    }

    protected function getUpdateRules(): array
    {
        $userId = $this->getRouteId();

        return [
            'name' => [
                'required',
                'regex:/^\S*$/',
                Rule::unique('users', 'name')->ignore($userId),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'password' => [
                'nullable',
                'confirmed',
                'min:6',
            ],
            'role_id' => 'nullable',
            'status' => 'nullable',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // New rule for profile_image
            'full_name' => 'nullable',
        ];
    }

    protected function getMessages(): array
    {
        return [
            'name.required' => 'The user name is required.',
            'name.unique' => 'This user name has already been taken.',
            'email.required' => 'The email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'role_id.required' => 'Please select a role for the user.',
            'status.required' => 'The user status is required.',
            'name.regex' => 'The username must not contain any spaces.',
        ];
    }

    protected function getCreateMessages(): array
    {
        return [
            'password.required' => 'A password is required for new users.',
        ];
    }
}
