<?php

namespace App\Modules\UserManagement\Requests\role;

use App\Core\Request\BaseFormRequest;
use Illuminate\Validation\Rule;

class create extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function getCreateRules(): array
    {
        return [
            'name' => 'required|unique:roles,name',
        ];
    }
    protected function getUpdateRules(): array
    {
        $roleId = $this->getRouteId();

        return [
            'name' => [
                'required',
                Rule::unique('roles', 'name')->ignore($roleId),
            ]
        ];
    }
}
