<?php

namespace App\Modules\UserManagement\Requests\permission;

use App\Core\Request\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class create extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function getCommonRules(): array
    {
        return array_merge(parent::getCommonRules(), [
            'name' => ['required', 'string', 'max:255'],
            'action' => ['required', 'string', 'max:255'],
            'controller' => ['required', 'string', 'max:255'],
            'group_name' => ['required', 'string', 'max:255'],
        ]);
    }
}
