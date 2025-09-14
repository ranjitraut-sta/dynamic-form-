<?php

namespace App\Modules\UserManagement\Mappers;

use App\Modules\UserManagement\DTOs\Role\RoleDto;
use App\Modules\UserManagement\Services\Interfaces\RoleServiceInterface;

class SelectOptionMapper
{
    protected $roleService;
    public function __construct(RoleServiceInterface $roleService)
    {
        $this->roleService = $roleService;
    }

    public function loadCommonSelectOptions(): array
    {
        return [
            'roles' => $this->roleService->getSelectOptions(RoleDto::class),
        ];
    }
}
